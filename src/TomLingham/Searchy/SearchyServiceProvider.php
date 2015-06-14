<?php namespace TomLingham\Searchy;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class SearchyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('searchy', function( $app )
		{
			return new SearchBuilder( $app['config'] );
		});

		$this->mergeConfigFrom(
			__DIR__ . '/../../config/config.php', 'searchy'
		);
	}

	/**
	 *
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../../config/config.php' => config_path('searchy.php'),
		]);
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

}
