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
    | Field Name
    |--------------------------------------------------------------------------
    |
    | This is the field name for the relevance attribute. You may change this
    | to whatever you prefer.
    |
    */

    'fieldName' => 'relevance',
    
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

        'fuzzy' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchDriver',
        ],

        'ufuzzy' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchUnicodeDriver',
        ],

        'simple' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\SimpleSearchDriver',
        ],

        'levenshtein' => [
            'class' => 'TomLingham\Searchy\SearchDrivers\LevenshteinSearchDriver',
        ],

    ],

];
