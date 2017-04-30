<?php

namespace TomLingham\Searchy\Matchers;

class PositionInSearchMatcher extends BaseMatcher
{
    public function buildQueryString($column, $searchString)
    {
        $query = "IF(
            POSITION(' $searchString' IN $column) = 0,
            0,
            $this->multiplier - ROUND(
                (POSITION('$searchString' IN $column) - 1) / CHAR_LENGTH($column) * $this->multiplier
            )
        )";

        return $query;
    }
}
