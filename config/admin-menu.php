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
        'title' => 'settings',
        'icon' => 'gears',
        'can' => 'admin.setting.*',
        'children' => [
            [
                'title' => 'information',
                'can' => 'admin.setting.info.read',
                'route' => 'admin.settings.info.index',
            ], [
                'title' => 'caches',
                'can' => 'admin.setting.cache.read',
                'route' => 'admin.settings.caches.index',
            ], [
                'title' => 'logs',
                'can' => 'admin.setting.log.read',
                'route' => 'admin.settings.logs.index',
            ],
        ],
    ],
    [
        'title' => 'users',
        'icon' => 'users',
        'children' => [
            [
                'title' => 'users list',
                'route' => 'admin.users.index',
            ],
            [
                'title' => 'create a new user',
                'route' => 'admin.users.create',
            ],
        ],
    ],
    [
        'title' => 'authorization',
        'icon' => 'lock-closed',
        'canany' => ['admin.role.index', 'admin.permission.index'],
        'children' => [
            [
                'title' => 'roles',
                'route' => 'admin.authorize.roles.index',
                'can' => 'admin.role.index',
            ],
            [
                'title' => 'permissions',
                'route' => 'admin.authorize.permissions.index',
                'can' => 'admin.permission.index',
            ],
        ],
    ],
];
