<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Coordinate Converter',
    'description' => 'View helper for converting geospatial coordinates from one format into another',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'Chris Müller',
    'author_email' => 'typo3@brotkrueml.dev',
    'version' => '3.4.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-14.3.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\BytCoordconverter\\' => 'Classes']
    ],
];
