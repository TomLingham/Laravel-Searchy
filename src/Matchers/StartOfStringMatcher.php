<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches Strings that begin with the search string.
 *
 * For example, a search for 'hel' would match; 'Hello World' or 'helping hand'
 *
 * Class StartOfStringMatcher
 */
class StartOfStringMatcher extends BaseMatcher
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
        return "$searchString%";
    }
}
