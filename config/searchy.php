<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the drivers below you wish to use as your
    | default driver for all work.
    |
    */

    'default' => 'fuzzy',

    /*
    |--------------------------------------------------------------------------
    | Searchy Drivers
    |--------------------------------------------------------------------------
    |
    | Here are each of the driver setup for your application. Default drivers
    | has been included, but you may add as many drivers as you would like.
    |
    */

    'drivers' => [
        'fuzzy' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchDriver',
        'levenshtein' => 'TomLingham\Searchy\SearchDrivers\LevenshteinSearchDriver',
        'simple' => 'TomLingham\Searchy\SearchDrivers\SimpleSearchDriver',
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Name
    |--------------------------------------------------------------------------
    |
    | This is the field name for the relevance attribute. You may change this
    | to whatever you prefer.
    |
    */

    'field' => 'relevance',
];
