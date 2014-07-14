<?php namespace TomLingham\Searchy\Matchers;

/**
 * Matches Studly Case strings using the first letters of the words only
 *
 * For example a search for 'hp' would match; 'HtmlServiceProvider' or 'HashParser' but not 'hasProvider'
 *
 * Class StudlyCaseMatcher
 * @package TomLingham\Searchy\Matchers
 */

class StudlyCaseMatcher extends BaseMatcher
{
	/**
	 * @var string
	 */
	protected $operator = 'LIKE BINARY';

	/**
	 * @var int
	 */
	protected $multiplier = 32;

	/**
	 * @param $searchString
	 * @return string
	 */
	public function formatSearchString( $searchString ) {

		return implode( '%', str_split(strtoupper( $searchString ))) . '%';
	}

	public function buildQueryString( $column, $searchString ){

		$query = "IF( CHAR_LENGTH( TRIM($column)) = CHAR_LENGTH( REPLACE( TRIM($column), ' ', '')) AND $column {$this->operator} '{$this->formatSearchString($searchString)}', {$this->multiplier}, 0)";

		return $query;
	}
}