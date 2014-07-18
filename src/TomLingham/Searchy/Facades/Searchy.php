<?php namespace TomLingham\Searchy\Facades;

use TomLingham\Searchy\SearchyServiceProvider;
use Illuminate\Support\Facades\Facade;

/**
 * Searchy facade for the Laravel framework
 */
class Searchy extends Facade
{
	/**
	 * Get the registered component.
	 *
	 * @return object
	 */
	protected static function getFacadeAccessor()
	{
		if (!static::$app)
			static::$app = SearchyServiceProvider::make();

		return 'searchy';
	}
}