<?php namespace Lukaskorl\Apigen;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Lukaskorl\Apigen\Artisan\PublishAssetsCommand;
use Lukaskorl\Apigen\Artisan\GenerateResourceCommand;
use Lukaskorl\Apigen\Artisan\GenerateRepositoryCommand;
use Lukaskorl\Apigen\Artisan\SetupAdminCommand;

class ApigenServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('lukaskorl/apigen');

        // Overwrite routes of frozennode/administrator
        include __DIR__.'/../../routes.php';
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register service providers of dependencies
        $this->app->register('Lukaskorl\Repository\RepositoryServiceProvider');

        // Overwrite the frozennode/administrator config
        $this->resetConfigNamespace();

        // Register the administration interface and other dependent service providers
        $this->app->register('Frozennode\Administrator\AdministratorServiceProvider');
        $this->app->register('Way\Generators\GeneratorsServiceProvider');

        // Overwrite the frozennode/administrator config
        $this->resetConfigNamespace();

        // Register commands
        $this->registerPublishCommand();
        $this->registerResourceCommand();
        $this->registerRepositoryCommand();
        $this->registerAdminCommand();
	}

    protected function registerPublishCommand()
    {
        $this->app['apigen.publish'] = $this->app->share(function($app)
        {
            return $app->make('Lukaskorl\Apigen\Artisan\PublishAssetsCommand');
        });
        $this->commands('apigen.publish');
    }

    protected function registerResourceCommand()
    {
        $this->app['apigen.resource'] = $this->app->share(function($app)
        {
            return $app->make('Lukaskorl\Apigen\Artisan\GenerateResourceCommand');
        });
        $this->commands('apigen.resource');
    }

    protected function registerRepositoryCommand()
    {
        $this->app['apigen.repository'] = $this->app->share(function($app)
        {
            return $app->make('Lukaskorl\Apigen\Artisan\GenerateRepositoryCommand');
        });
        $this->commands('apigen.repository');
    }

    protected function registerAdminCommand()
    {
        $this->app['apigen.admin'] = $this->app->share(function($app)
        {
            return $app->make('Lukaskorl\Apigen\Artisan\SetupAdminCommand');
        });
        $this->commands('apigen.admin');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return __DIR__ . '/../../config';
    }

    /**
     * Reset the "administrator" config namespace
     */
    protected function resetConfigNamespace()
    {
        // Overwrite the namespaces
        // Config::getLoader()->addNamespace('administrator', $this->getConfigPath());
        Config::addNamespace('administrator', $this->getConfigPath());

        // Immediately call the config and load the files
        return Config::get('administrator::administrator');
    }

}
