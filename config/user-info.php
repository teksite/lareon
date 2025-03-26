<?php

return [

    "social" => [
        /*
       |--------------------------------------------------------------------------
       | Social Information
       |--------------------------------------------------------------------------
       |
       | * In this section, you can add a new item to the 'Extra Information' section on the 'User Edit' page.
       | * Each item should be an array containing a key as the label and an array key for conditions.
       |    'type' => Input type (url, email, tel, text, textarea),
       |    'show' => 1 to show, 0 to hide, and -1 for user selection,
       |    'active' => Boolean to determine whether it is active on the edit page.
       */
        "instagram" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "linkedin" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "whatsapp" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "telegram" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "twitter" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "facebook" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "wikipedia" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "pinterest" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],

        "email" => [
            'type' => 'email',
            'show' => -1,
            'active' => true
        ],
        "phone" => [
            'type' => 'tel',
            'show' => -1,
            'active' => true
        ],
        "company" => [
            'type' => 'text',
            'show' => -1,
            'active' => true
        ],
        "address" => [
            'type' => 'textarea',
            'show' => -1,
            'active' => true
        ],

        "github" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],
        "gitlab" => [
            'type' => 'url',
            'show' => -1,
            'active' => true
        ],

        "website" => [
            'type' => 'text',
            'show' => -1,
            'active' => true
        ],

        "about" => [
            'type' => 'textarea',
            'show' => -1,
            'active' => true
        ],
    ]
];
