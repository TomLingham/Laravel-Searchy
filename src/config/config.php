<?php

return [

	'default' => 'fuzzy',

	'sanitize' => true,

	'sanitizeRegEx' => '/[%\']+/i',

	'fieldName' => 'relevance',

	'drivers' => [

		'fuzzy' => [
			'class' => 'TomLingham\Searchy\SearchDrivers\FuzzySearchDriver'
		],

		'simple' => [
			'class' => 'TomLingham\Searchy\SearchDrivers\SimpleSearchDriver'
		],

		'levenshtein' => [
			'class' => 'TomLingham\Searchy\SearchDrivers\LevenshteinSearchDriver'
		],


	],



];