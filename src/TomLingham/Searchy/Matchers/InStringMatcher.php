<?php namespace TomLingham\Searchy\Matchers;

/**
 * Matches against any occurrences of a string within a string and is case-insensitive.
 *
 * For example, a search for 'smi' would match; 'John Smith' or 'Smiley Face'
 *
 * Class InStringMatcher
 * @package TomLingham\Searchy\Matchers
 */

class InStringMatcher extends BaseMatcher
{

	/**
	 * @var string
	 */
	protected $operator = 'LIKE';

	/**
	 * @var int
	 */
	protected $multiplier = 30;

	/**
	 * @param $searchString
	 * @return string
	 */
	public function formatSearchString( $searchString ){
		return "%$searchString%";
	}
}