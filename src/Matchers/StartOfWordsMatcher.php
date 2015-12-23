<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches the start of each word against each word in a search.
 *
 * For example, a search for 'jo ta' would match; 'John Taylor' or 'Joshua B. Takashi'
 *
 * Class StartOfWordsMatcher
 */
class StartOfWordsMatcher extends BaseMatcher
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
        return implode('% ', explode(' ', $searchString)).'%';
    }
}
