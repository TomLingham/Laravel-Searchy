<?php

namespace TomLingham\Searchy;

use Illuminate\Support\ServiceProvider;

class SearchyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Registers searchy.
     */
    public function registerSearchy()
    {
        // Laravel <= 5.1
        $closure = function ($app) {
            return new SearchBuilder( $app['config'] );
        };


        if ( method_exists($this->app, 'bindShared') )
        {
            $this->app->bindShared('searchy', $closure);
        }

        // Laravel 5.2 Goodness :)
        else {
            $this->app->singleton('searchy', $closure);
        }
    }

    /**
     * Loads the configuration file.
     */
    public function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/searchy.php');

        if (class_exists('Illuminate\Foundation\Application', false)) {
            $this->publishes([$source => config_path('searchy.php')]);
        }

        $this->mergeConfigFrom($source, 'searchy');
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->setupConfig();
        $this->registerSearchy();
    }
}
