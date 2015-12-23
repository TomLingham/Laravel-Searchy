<?php

namespace TomLingham\Searchy\SearchDrivers;

class SimpleSearchDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class                 => 100,
        \TomLingham\Searchy\Matchers\StartOfStringMatcher::class         => 50,
        \TomLingham\Searchy\Matchers\InStringMatcher::class              => 30,
    ];
}
