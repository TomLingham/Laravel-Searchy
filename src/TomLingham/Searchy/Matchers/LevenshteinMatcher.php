<?php namespace TomLingham\Searchy\Matchers;

/**
 * Matches strings for Acronym 'like' matches but does NOT return Studly Case Matches
 *
 * for example, a search for 'fb' would match; 'foo bar' or 'Fred Brown' but not 'FreeBeer'.
 *
 * Class AcronymMatcher
 * @package TomLingham\Searchy\Matchers
 */

class LevenshteinMatcher extends BaseMatcher
{

	/**
	 * @param $column
	 * @param $searchString
	 * @return mixed|string
	 */
	public function buildQueryString( $column, $searchString )
	{
		return "levenshtein($column, '$searchString')";
	}

}