<?php

namespace Soap\ThProvinces;

use Soap\ThProvinces\Provinces\Provinces;
use Soap\ThProvinces\Commands\MigrationCommand;
use Illuminate\Support\ServiceProvider;

class ProvincesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/thprovinces.php' => config_path('thprovinces.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/Config/thprovinces.php', 'thprovinces');
        $this->registerProvinces();
        $this->registerCommands();
    }

    protected function registerProvinces()
    {
        $this->app['thprovinces'] = $this->app->share(function($app) {
            return new Provinces;
        });
    }

    protected function registerCommands()
    {
        $this->app['command.provinces.migration'] = $this->app->share(function($app)
        {
            return new MigrationCommand($app);
        });

        $this->commands('command.provinces.migration');
    }
}
