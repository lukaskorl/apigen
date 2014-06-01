<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Lukaskorl\Apigen\Naming\Translator;
use Lukaskorl\Apigen\Parsers\FieldsParser;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateResourceCommand extends GeneratorCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apigen:resource';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a complete resource including API interface, repository and admin interface';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        // Prepare input
        $namespace = $this->getNamespace();
        $path = $this->getPath();

        // Prepare schema fields
        if ( ! $this->option('no-migration')) {
            $this->generateSchemaMigration();
        }

        // 2. Generate model
        $this->call('apigen:model', [
            'name' => $this->translator->translate($this->argument('name'))->toModelName(),
            '--path' => $path,
            '--namespace' => $namespace
        ]);

        // 3. Generate repository
        $this->call('apigen:repository', [
            'name' => $this->translator->translate($this->argument('name'))->toModelName(),
            '--path' => $path,
            '--namespace' => $namespace
        ]);

        // 4. Generate controller
        if ( ! $this->option('no-controller')) {
            $this->generateController();
        }

        // 5. Setup API route
        if ( ! $this->option('no-route')) {
            // TODO
        }

        // 6. Setup administration interface if needed
        if ( ! $this->option('no-admin')) {
            $this->setupAdministrationBackend();
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
            [ 'name', InputArgument::REQUIRED, 'Singular name of the resource' ],
        ];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
            [ 'no-admin', 'na', InputOption::VALUE_NONE, 'Omit the setup of the admin interface' ],
            [ 'no-route', 'nr', InputOption::VALUE_NONE, 'Omit the setup of API route' ],
            [ 'no-controller', 'nc', InputOption::VALUE_NONE, 'Omit the setup of API controller' ],
            [ 'no-migration', 'nm', InputOption::VALUE_NONE, 'Omit the generation of a migration file' ],
            [ 'fields', 'f', InputOption::VALUE_OPTIONAL, 'Type for resource' ],
            [ 'apiversion', 'api', InputOption::VALUE_OPTIONAL, 'Versioning of the API routes', 1 ],

            [ 'namespace', null, InputOption::VALUE_OPTIONAL, 'Base namespace for generated code. You can set a project wide default value fot this in the config.' ],
            [ 'path', null, InputOption::VALUE_OPTIONAL, 'Base path for generated code. You can set a project wide default value fot this in the config.' ],
        ];
	}

    /**
     * Create configuration for backend
     * @return int
     */
    protected function setupAdministrationBackend()
    {
        // Generate administration interface
        return $this->call('apigen:admin', [
            'name' => $this->argument('name'),
            '--fields' => $this->option('fields')
        ]);
    }

    /**
     * Generate the command / filename for a migration
     * @return string
     */
    protected function generateMigrationName()
    {
        return 'create_' . $this->translator->translate($this->argument('name'))->toTableName() . '_table';
    }

    /**
     * Generate the classname of a migration
     * @return string
     */
    protected function generateMigrationClassname()
    {
        return ucwords($this->translator->translate('create_' . $this->translator->translate($this->argument('name'))->toTableName() . '_table')->toModelName());
    }

    /**
     * Generate a migration file
     * @return $this
     */
    protected function generateSchemaMigration()
    {
        // Guard to prevent double generation of a migration file
        $classname = $this->generateMigrationClassname();
        if (class_exists($classname)) {
            $this->error("Schema migration file already exists. Will not create a migration.");
            return $this;
        }

        $fields = $this->parser->parse($this->option('fields'));
        $commandFields = [];
        foreach ($fields as $field) {
            $commandFields[] = $field['property'] . ':' . $field['field']->toSchemaDefinition();
        }

        // Create migration
        $this->call('generate:migration', [
            'migrationName' => $this->generateMigrationName(),
            '--fields' => implode(', ', $commandFields)
        ]);

        return $this;
    }

    /**
     * Generate the API controller
     */
    protected function generateController()
    {
        $translatableName = $this->translator->translate($this->argument('name'));
        $namespace = $this->getNamespace(true, $translatableName->toReadablePlural());
        $path = $this->getPath($namespace);
        $target = "$path/{$translatableName->toRepositoryName()}Controller.php";

        // Render and create repository controller if not exists
        if (!$this->filesystem->exists($target)) {
            $this->renderTemplate('controller_class.txt', $target, [
                'NAMESPACE' => $namespace,
                'CLASSNAME' => "{$translatableName->toRepositoryName()}Controller",
                'REPOSITORY' => "Eloquent{$translatableName->toRepositoryName()}Repository"
            ]);
        } else {
            $this->error("Controller for repository '{$translatableName->toRepositoryName()}Repository' already exists.");
        }
    }

}
