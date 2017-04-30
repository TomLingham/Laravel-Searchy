<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Mathes the search term preceded by common determiners and applies the appropriate multiplier
 * if it matches.
 *
 * For example, a search for 'gar', will match 'The Garage Band', or 'a garden'.
 *
 * Class DeterminerMatcher
 */
class DeterminerMatcher extends BaseMatcher
{

    public function buildQueryString($column, $searchString)
    {
        $determiners = [
            'the',
            'a', 'an',
            'here', 'there', 'this', 'that', 'these', 'those',
            'i',
        ];

        $queries = array_map(function($d) use ($searchString, $column) {
            return "IF($column LIKE '$d $searchString%', $this->multiplier, 0)";
        }, $determiners);

        $query = implode($queries, ' + ');

        return $query;
    }
}
