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
		//
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
            [ 'no-admin', 'na', InputOption::VALUE_NONE, 'Omit the setup of the admin interface' ],
            [ 'no-route', 'nr', InputOption::VALUE_NONE, 'Omit the setup of API route' ],
            [ 'fields', 'f', InputOption::VALUE_OPTIONAL, 'Fields for resource' ],
            [ 'apiversion', 'api', InputOption::VALUE_OPTIONAL, 'Versioning of the API routes', 1 ],

            [ 'namespace', null, InputOption::VALUE_OPTIONAL, 'Base namespace for generated code. You can set a project wide default value fot this in the config.' ],
            [ 'path', null, InputOption::VALUE_OPTIONAL, 'Base path for generated code. You can set a project wide default value fot this in the config.' ],
        ];
	}

}
