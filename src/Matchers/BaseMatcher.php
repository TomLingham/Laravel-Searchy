<?php

namespace TomLingham\Searchy\Matchers;

use TomLingham\Searchy\Interfaces\MatcherInterface;

/**
 * @property mixed multiplier
 * @property mixed operator
 */
abstract class BaseMatcher implements MatcherInterface
{
    protected $multiplier;

    public function __construct($multiplier)
    {
        $this->multiplier = $multiplier;
    }

    /**
     * The default process for building the Query string.
     *
     * @param $column
     * @param $searchString
     *
     * @return mixed|string
     */
    public function buildQueryString($column, $searchString)
    {
        if (method_exists($this, 'formatSearchString'))
            $searchString = $this->formatSearchString($searchString);

        if (env('DB_CONNECTION')=='mysql') {
            return "IF($column {$this->operator} '$searchString', {$this->multiplier}, 0)";
        }else if (env('DB_CONNECTION')=='pgsql') {
            return "(CASE WHEN ($column {$this->operator} '$searchString') THEN {$this->multiplier} ELSE 0 END)";
        }
    }
}
