<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches against any occurrences of a string within a string and is case-insensitive.
 *
 * For example, a search for 'smi' would match; 'John Smith' or 'Smiley Face'
 *
 * Class InStringMatcher
 */
class InStringMatcher extends BaseMatcher
{
    /**
     * @var string
     */
    protected $operator = 'LIKE';

    /**
     * @param $searchString
     *
     * @return string
     */
    public function formatSearchString($searchString)
    {
        return "%$searchString%";
    }
}
