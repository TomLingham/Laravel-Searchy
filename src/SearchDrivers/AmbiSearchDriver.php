<?php

namespace TomLingham\Searchy\SearchDrivers;

class AmbiSearchDriver extends BaseSearchDriver
{
    protected $matchers = [
        \TomLingham\Searchy\Matchers\ExactMatcher::class                 => 150,
        \TomLingham\Searchy\Matchers\DeterminerMatcher::class            => 110,
        \TomLingham\Searchy\Matchers\PositionInSearchMatcher::class      => 100,
        \TomLingham\Searchy\Matchers\StartOfStringMatcher::class         => 90,
        \TomLingham\Searchy\Matchers\InsideStartOfWordsMatcher::class    => 50,
        \TomLingham\Searchy\Matchers\StartOfWordsMatcher::class          => 35,
    ];
}
