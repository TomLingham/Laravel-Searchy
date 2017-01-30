<?php

namespace TomLingham\Searchy;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the searchy service provider class.
 *
 * @author Tom Lingham <tjlingham@gmail.com>
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class SearchyServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/searchy.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('searchy.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('searchy');
        }

        $this->mergeConfigFrom($source, 'searchy');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSearchBuilder();
    }

    /**
     * Register the search builder class.
     *
     * @return void
     */
    public function registerSearchBuilder()
    {
        $this->app->singleton('searchy', function (Container $app) {
            $config = $app['config'];

            return new SearchBuilder($config);
        });

        $this->app->alias('searchy', SearchBuilder::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'searchy',
        ];
    }
}
