<?php


return [
    'modules' => ['admin', 'frontend', 'api'],
    'sections' => [
        [
            'name' => 'Section 1',
            'folder' => 'sec1',
            'subdomain' => 'sec1',
            'visibleIn' => ['admin'],
        ],
        [
            'name' => 'Section 2',
            'folder' => 'sec2',
            'subdomain' => 'sec2',
            'visibleIn' => ['admin', 'frontend'],
        ],
        [
            'name' => 'Section 3',
            'folder' => 'sec3',
            'subdomain' => 'sec3',
            'visibleIn' => ['frontend'],
        ],
    ],
];
