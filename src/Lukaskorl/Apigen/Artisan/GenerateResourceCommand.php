<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateResourceCommand extends Command {

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
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        // 1. Generate migration
        // TODO

        // 2. Generate model
        // TODO

        // 3. Generate repository
        // TODO

        // 4. Generate controller
        // TODO

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

}
