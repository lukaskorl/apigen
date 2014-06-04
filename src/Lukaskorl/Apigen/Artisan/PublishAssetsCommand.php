<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App, Config;

class PublishAssetsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'apigen:publish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publishes all assets and configuration files for APIgen.';

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
        $this->info("APIgen is preparing your API ...");

		// Publish assets of frozennode/administrator
        $this->call('asset:publish', [ 'frozennode/administrator' ]);
        $this->call('asset:publish', [ 'lukaskorl/apigen' ]);

        // Publishing the configuration file
        //$this->call('config:publish', [ 'lukaskorl/apigen' ]);

        // Create directories for configuration files
        $this->info("Setting up backend configuration ...");
        $this->createDirectory(Config::get('administrator::administrator.model_config_path'));
        $this->createDirectory(Config::get('administrator::administrator.settings_config_path'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

    /**
     * Create a directory if it does not exist
     * @param $path
     * @return mixed
     */
    protected function createDirectory($path)
    {
        $filesystem = App::make('files');
        if (!$filesystem->isDirectory($path)) {
            $this->comment("Creating directory: ".$path);
            $filesystem->makeDirectory($path, 0777, true);
            return $filesystem;
        }
        return $filesystem;
    }

}
