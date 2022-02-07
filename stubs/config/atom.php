<?php

return [
    'locales' => ['en'],
    'max_upload_size' => 8,
    'timezone' => 'Asia/Kuala_Lumpur',

    'features' => [
        'auth' => [
            'register' => true,
            'forgot-password' => true,
            'verify' => true,
        ],
        'labels' => [
            'blog-category',
        ],
        'roles' => true,
        'abilities' => true,
        'pages' => true,
        'teams' => true,
        'blogs' => true,
        'enquiries' => true,
        'tickets' => true,
        'site_settings' => 'minimal',   // 'minimal' or 'cms'
    ],

    'models' => [
        //
    ],
];