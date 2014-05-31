<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Log\Writer;
use Illuminate\Support\Pluralizer;
use Lukaskorl\Apigen\Naming\Name;
use Lukaskorl\Apigen\Naming\Translator;
use Lukaskorl\Apigen\Parsers\FieldsParser;
use Lukaskorl\Apigen\Templating\Generator;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App, Config;

class SetupAdminCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apigen:admin';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup administration interface for a given resource.';

    /**
     * @var ConfigRepository
     */
    private $config;

    /**
     * @var \Lukaskorl\Apigen\Naming\Translator
     */
    private $translator;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var \Lukaskorl\Apigen\Templating\Generator
     */
    private $generator;

    /**
     * @var \Lukaskorl\Apigen\Parsers\FieldsParser
     */
    private $parser;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \Lukaskorl\Apigen\Naming\Translator $translator
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @param \Lukaskorl\Apigen\Templating\Generator $generator
     * @return \Lukaskorl\Apigen\Artisan\SetupAdminCommand
     */
	public function __construct(ConfigRepository $config, Translator $translator, Filesystem $filesystem, Generator $generator, FieldsParser $parser)
	{
		parent::__construct();
        $this->config = $config;
        $this->translator = $translator;
        $this->filesystem = $filesystem;
        $this->generator = $generator;
        $this->parser = $parser;
    }

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        // Prepare input
        $name = $this->getResourceName();
        $fields = $this->parser->parse($this->option('fields'));

        // Generate the model config
        $this->info("Generating model configuration for '{$name->toReadableName()}' ...");
        $modelConfig = $this->generateModelConfigFromTemplate($name, $fields);

        $this->info("Saving model configuration of '{$name->toReadableName()}' to file ...");
        $this->saveToModelConfig($name, $modelConfig);

        // Check if the resource is already registered in the menu
        if ( ! $this->isNameRegisteredInAdministrationMenu($name)) {
            $this->info("Adding '{$name->toReadableName()}' to administration menu ...");
            $this->addNameToAdministrationMenu($name);
        } else {
            $this->error("Administration menu entry for '{$name->toReadableName()}' already exists.");
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
			[ 'name', InputArgument::REQUIRED, 'Singluar name of the resource.' ],
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
            [ 'fields', 'f', InputOption::VALUE_OPTIONAL, 'Type for resource' ],
        ];
	}

    /**
     * Check if the given resource is already registered in the administration menu
     * @param $name
     * @return mixed
     */
    protected function isNameRegisteredInAdministrationMenu($name)
    {
        return array_search($name->toAdminName(), $this->config->get('administrator::administrator.menu'));
    }

    /**
     * Generate the name of the resource to create
     * @return \Lukaskorl\Apigen\Naming\Name
     */
    protected function getResourceName()
    {
        return $this->translator->translate($this->argument('name'));
    }

    /**
     * Add the given resource name to the administration menu
     * @param $name
     * @return int
     */
    protected function addNameToAdministrationMenu($name)
    {
        // If the resource could not be found prepend it to the placeholder
        $configFile = $this->getAdministratorConfigPath();

        // 1. Read content of file
        $config = $this->filesystem->get($configFile);

        // 2. Replace
        $config = preg_replace("/[\w\[\]\s\/\*]*#->apigen.menu.placeholder[\w\[\]\s\/\*]*/smi", "\n        '{$name->toAdminName()}',$0", $config);

        // 3. Save file
        return $this->filesystem->put($configFile, $config);
    }

    /**
     * Return path of the administrator.php config file
     * @return string
     */
    protected function getAdministratorConfigPath()
    {
        return $this->config->getNamespaces()['apigen'] . '/administrator.php';
    }

    /**
     * Process the template and automatically fill in the values
     * @param $name
     * @param $fields
     * @return mixed
     */
    protected function generateModelConfigFromTemplate($name, array $fields)
    {
        // Prepare fields
        $listFields = [];
        foreach($fields as $field) {
            $listFields[$field['property']] = [
                'title' => $this->translator->translate($field['property'])->toReadableName()
            ];
        }

        // Prepare edit fields
        $editFields = [];
        foreach($fields as $field) {
            $editFields[$field['property']] = array_merge([
                // Default values (may be overwritten by merging in edit fields configuration)
                'title' => $this->translator->translate($field['property'])->toReadableName(),
                'type' => $field['field']->getAdminType()
            ], $field['field']->generateEditFieldsConfiguration());
        }

        // Compile configuration template
        return $this->generator->compile('model_config.txt', [
            'MODEL_TITLE_SINGULAR' => $name->toReadableName(),
            'MODEL_TITLE_PLURAL' => $name->toReadablePlural(),
            'MODEL_SINGULAR' => $name->toSingularForm(),
            'MODEL_ELOQUENT' => $name->toModelName(),
            'MODEL_LIST_COLUMNS' => $listFields,
            'MODEL_EDIT_FIELDS' => $editFields
        ]);
    }

    /**
     * Write the config for the model to file
     * @param Name $name
     * @param $template
     * @return int
     */
    private function saveToModelConfig(Name $name, $template)
    {
        return $this->filesystem->put(
            $this->config->get('administrator::administrator.model_config_path') . '/' . $name->toTableName() . '.php',
            $template
        );
    }

}
