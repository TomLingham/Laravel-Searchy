<?php namespace TomLingham\Searchy;

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
		$this->app->bindShared('searchy', function($app)
		{
			return new SearchBuilder();
		});
	}

	/**
	 *
	 */
	public function boot()
	{
		$this->package('tom-lingham/searchy');
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
