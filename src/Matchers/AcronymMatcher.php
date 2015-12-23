<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches strings for Acronym 'like' matches but does NOT return Studly Case Matches.
 *
 * for example, a search for 'fb' would match; 'foo bar' or 'Fred Brown' but not 'FreeBeer'.
 *
 * Class AcronymMatcher
 */
class AcronymMatcher extends BaseMatcher
{
    /**
     * @var string
     */
    protected $operator = 'LIKE';

    /**
     * @param $searchString
     *
     * @return mixed|string
     */
    public function formatSearchString($searchString)
    {
        $searchString = preg_replace('/[^0-9a-zA-Z]/', '', $searchString);

        return implode('% ', str_split(strtoupper($searchString))).'%';
    }
}
