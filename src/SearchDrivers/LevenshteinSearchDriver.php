<?php

namespace TomLingham\Searchy\SearchDrivers;

class LevenshteinSearchDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\LevenshteinMatcher::class           => 100,
    ];
}
