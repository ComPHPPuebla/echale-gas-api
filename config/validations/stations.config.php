<?php
return [
    'required' => [[[
        'name',
        'social_reason',
        'address_line_1',
        'address_line_2',
        'location',
        'latitude',
        'longitude',
    ]]],
    'numeric' => [[[
        'latitude',
        'longitude',
    ]]],
    'length' => [
        ['name', 1, 100],
        ['social_reason', 1, 100],
        ['address_line_1', 1, 150],
        ['address_line_2', 1, 80],
        ['location', 1, 100],
    ],
];
