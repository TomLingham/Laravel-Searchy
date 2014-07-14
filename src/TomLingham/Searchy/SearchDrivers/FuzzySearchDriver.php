<?php namespace TomLingham\Searchy\SearchDrivers;

class FuzzySearchDriver extends BaseSearchDriver {

	/**
	 * @var array
	 */
	protected $matchers = [
		'TomLingham\Searchy\Matchers\ExactMatcher'                 => 100,
		'TomLingham\Searchy\Matchers\StartOfStringMatcher'         => 50,
		'TomLingham\Searchy\Matchers\AcronymMatcher'               => 42,
		'TomLingham\Searchy\Matchers\ConsecutiveCharactersMatcher' => 40,
		'TomLingham\Searchy\Matchers\StartOfWordsMatcher'          => 35,
		'TomLingham\Searchy\Matchers\StudlyCaseMatcher'            => 32,
		'TomLingham\Searchy\Matchers\InStringMatcher'              => 30,
		'TomLingham\Searchy\Matchers\TimesInStringMatcher'         => 8,
	];

}