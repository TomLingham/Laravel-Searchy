<?php

namespace TomLingham\Searchy\SearchDrivers;

class FuzzySearchUnicodeDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class                        => 100,
        \TomLingham\Searchy\Matchers\StartOfStringMatcher::class                => 50,
        \TomLingham\Searchy\Matchers\AcronymUnicodeMatcher::class               => 42,
        \TomLingham\Searchy\Matchers\ConsecutiveCharactersUnicodeMatcher::class => 40,
        \TomLingham\Searchy\Matchers\StartOfWordsMatcher::class                 => 35,
        \TomLingham\Searchy\Matchers\StudlyCaseUnicodeMatcher::class            => 32,
        \TomLingham\Searchy\Matchers\InStringMatcher::class                     => 30,
        \TomLingham\Searchy\Matchers\TimesInStringMatcher::class                => 8,
  ];
}
