<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches strings for Acronym 'like' matches but does NOT return Studly Case Matches.
 *
 * for example, a search for 'fb' would match; 'foo bar' or 'Fred Brown' but not 'FreeBeer'.
 *
 * Class AcronymMatcher
 */
class AcronymUnicodeMatcher extends BaseMatcher
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
        $results = [];
        preg_match_all('/./u', mb_strtoupper($searchString, 'UTF-8'), $results);

        return implode('% ', $results[0]).'%';
    }
}
