<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Coordinate Converter',
    'description' => 'View helper for converting geospatial coordinates from one format into another',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '3.2.0',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-',
            'typo3' => '11.5.0-13.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\BytCoordconverter\\' => 'Classes']
    ],
];
