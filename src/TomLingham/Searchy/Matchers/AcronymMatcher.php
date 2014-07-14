<?php namespace TomLingham\Searchy\Matchers;

/**
 * Matches strings for Acronym 'like' matches but does NOT return Studly Case Matches
 *
 * for example, a search for 'fb' would match; 'foo bar' or 'Fred Brown' but not 'FreeBeer'.
 *
 * Class AcronymMatcher
 * @package TomLingham\Searchy\Matchers
 */

class AcronymMatcher extends BaseMatcher
{
	/**
	 * @var string
	 */
	protected $operator = 'LIKE';

	/**
	 * @var int
	 */
	protected $multiplier = 42;

	/**
	 * @param $searchString
	 * @return mixed|string
	 */
	public function formatSearchString( $searchString ) {

		return implode( '% ', str_split(strtoupper( $searchString ))) . '%';
	}
}