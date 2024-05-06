<?php


return [
    'users' => [
        'base_uri' => env('USER_SERVICE_BASE_URI'),
        'secret' => env('USER_SERVICE_SECRET')
    ],
    'notes' => [
        'base_uri' => env('NOTE_SERVICE_BASE_URI'),
        'secret' => env('NOTE_SERVICE_SECRET'),
    ]
];
