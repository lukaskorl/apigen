<?php namespace Lukaskorl\Apigen\Artisan;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Log\Writer;
use Illuminate\Support\Pluralizer;
use Lukaskorl\Apigen\Naming\Translator;
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
     * Create a new command instance.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \Lukaskorl\Apigen\Naming\Translator $translator
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     * @return \Lukaskorl\Apigen\Artisan\SetupAdminCommand
     */
	public function __construct(ConfigRepository $config, Translator $translator, Filesystem $filesystem)
	{
		parent::__construct();
        $this->config = $config;
        $this->translator = $translator;
        $this->filesystem = $filesystem;
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
        $modelConfigPath = $this->config->get('administrator::administrator.model_config_path');

        // Check if the resource is already registered in the menu
        if ( ! $this->isNameRegisteredInAdministrationMenu($name)) {
            $this->info("Adding '{$name->toReadable()}' to administration menu ...");
            $this->addNameToAdministrationMenu($name);
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
            [ 'fields', 'f', InputOption::VALUE_OPTIONAL, 'Fields for resource' ],
            [ 'title', null, InputOption::VALUE_OPTIONAL, 'Set the title used in the menu' ],
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

}
