<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches Studly Case strings using the first letters of the words only.
 *
 * For example a search for 'hp' would match; 'HtmlServiceProvider' or 'HashParser' but not 'hasProvider'
 *
 * Class StudlyCaseMatcher
 */
class StudlyCaseMatcher extends BaseMatcher
{
    /**
     * @var string
     */
    protected $operator = 'LIKE BINARY';

    /**
     * @param $searchString
     *
     * @return string
     */
    public function formatSearchString($searchString)
    {
        $searchString = preg_replace('/[^0-9a-zA-Z]/', '', $searchString);

        return implode('%', str_split(strtoupper($searchString))).'%';
    }

    public function buildQueryString($column, $searchString)
    {
        return "IF( CHAR_LENGTH( TRIM( $column )) = CHAR_LENGTH( REPLACE( TRIM( $column ), ' ', '')) AND $column {$this->operator} '{$this->formatSearchString($searchString)}', {$this->multiplier}, 0)";
    }
}
