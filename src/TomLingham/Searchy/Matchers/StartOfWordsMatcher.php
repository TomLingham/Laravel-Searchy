<?php namespace TomLingham\Searchy\Matchers;

/**
 * Matches the start of each word against each word in a search
 *
 * For example, a search for 'jo ta' would match; 'John Taylor' or 'Joshua B. Takashi'
 *
 * Class StartOfWordsMatcher
 * @package TomLingham\Searchy\Matchers
 */

class StartOfWordsMatcher extends BaseMatcher
{

	/**
	 * @var string
	 */
	protected $operator = 'LIKE';

	/**
	 * @var int
	 */
	protected $multiplier = 35;

	/**
	 * @param $searchString
	 * @return string
	 */
	public function formatSearchString( $searchString ) {
		return implode('% ', explode(' ', $searchString)) . '%';
	}
}