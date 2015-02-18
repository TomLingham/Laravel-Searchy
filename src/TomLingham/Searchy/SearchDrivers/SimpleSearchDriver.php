<?php namespace TomLingham\Searchy\SearchDrivers;

class SimpleSearchDriver extends BaseSearchDriver {

	/**
	 * @var array
	 */
	protected $matchers = [
		'TomLingham\Searchy\Matchers\ExactMatcher'                 => 100,
		'TomLingham\Searchy\Matchers\StartOfStringMatcher'         => 50,
		'TomLingham\Searchy\Matchers\InStringMatcher'              => 30,
	];

}