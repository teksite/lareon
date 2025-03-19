<?php
return [
    [
        'title' => 'dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'gauge',
    ],
    [
        'title' => 'appearance',
        'icon' => 'columns-three',
        'children' => [
            [
                'title' => 'icons library',
                'route' => 'admin.appearance.icons.index',
            ],
        ],
    ],
    [
        'title' => 'authorization',
        'icon' => 'lock-closed',
        'children' => [
            [
                'title' => 'roles',
                'route' => 'admin.authorize.roles.index',
            ],
            [
                'title' => 'permissions',
                'route' => 'admin.authorize.permissions.index',
            ],
        ],
    ],
];
