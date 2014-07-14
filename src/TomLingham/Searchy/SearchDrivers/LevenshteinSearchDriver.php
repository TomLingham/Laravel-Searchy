<?php namespace TomLingham\Searchy\SearchDrivers;

class LevenshteinSearchDriver extends BaseSearchDriver {


	private $sensitivity = 10;

	protected $matchers = [
		'TomLingham\Searchy\Matchers\LevenshteinMatcher' => 100
	];


	public function setSensitivity( $sensitivity ){

		$this->sensitivity = $sensitivity;

		return $this;
	}


	/**
	 * @param $column
	 * @param $matcherClass
	 * @param $multiplier
	 * @return mixed
	 */
	protected function makeMatcher( $column, $matcherClass, $multiplier )
	{
		$matcher = new $matcherClass( $multiplier );
		$matcher->setSensitivity( $this->sensitivity );

		return $matcher->buildQueryString( $column, $this->searchString );

	}

}