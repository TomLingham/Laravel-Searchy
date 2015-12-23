<?php

namespace TomLingham\Searchy\Interfaces;

interface MatcherInterface
{
    /**
     * Builds the string to add to the SELECT statement for the Matcher.
     *
     * @param $column
     * @param $searchString
     *
     * @return mixed
     */
    public function buildQueryString($column, $searchString);
}
