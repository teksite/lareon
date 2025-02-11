<?php

return [
    "cms" => [
        [
            'position' => 0,
            'icon' => 'gage',
            "label" => "Dashboard",
            'route' => 'admin.dashboard',
        ],
        [
            'position' => 100,
            "label" => "authorization",
            'icon' => 'lock-closed',
            'is_active'=>'admin.authorize.*',

            'sub' => [
                [
                    "label" => 'permissions',
                    'route' => 'admin.authorize.permissions.index',
                    'is_active'=>'admin.authorize.permissions.*'
                ],
                [
                    "label" => 'roles',
                    'route' => 'admin.authorize.roles.index',
                    'is_active'=>'admin.authorize.roles.*',
                ],
            ]

        ]

    ],
];
