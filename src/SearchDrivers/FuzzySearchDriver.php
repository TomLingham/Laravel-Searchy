<?php

namespace TomLingham\Searchy\SearchDrivers;

class FuzzySearchDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class                 => 100,
        \TomLingham\Searchy\Matchers\StartOfStringMatcher::class         => 50,
        \TomLingham\Searchy\Matchers\AcronymMatcher::class               => 42,
        \TomLingham\Searchy\Matchers\ConsecutiveCharactersMatcher::class => 40,
        \TomLingham\Searchy\Matchers\StartOfWordsMatcher::class          => 35,
        \TomLingham\Searchy\Matchers\StudlyCaseMatcher::class            => 32,
        \TomLingham\Searchy\Matchers\InStringMatcher::class              => 30,
        \TomLingham\Searchy\Matchers\TimesInStringMatcher::class         => 8,
];
}
