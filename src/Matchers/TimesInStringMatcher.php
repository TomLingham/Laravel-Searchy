<?php

namespace TomLingham\Searchy\Matchers;

/**
 * Matches a string based on how many times the search string appears inside the string
 * it then applies the multiplier for each occurrence.
 *
 * For example, a search for 'tha' would match; 'I hope that that cat has caught that mouse' (3 x multiplier) or 'Thanks, it was great!' (1 x multiplier)
 *
 * Class TimesInStringMatcher
 */
class TimesInStringMatcher extends BaseMatcher
{
    /**
     * @param $column
     * @param $searchString
     *
     * @return mixed|string
     */
    public function buildQueryString($column, $searchString)
    {
        $query = "{$this->multiplier} * ROUND((
			CHAR_LENGTH($column) - CHAR_LENGTH( REPLACE( LOWER($column), lower('$searchString'), ''))
		) / LENGTH('$searchString'))";

        return $query;
    }
}
