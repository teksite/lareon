<?php

return [
    "cms" => [
        [
            'position' => 0,
            'icon' => 'gage',
            "label" => "Dashboard",
            'route' => 'admin.dashboard',
            'permission' => 'admin',
        ],
        [
            'position' => 50,
            "label" => "appearance",
            'icon' => 'columns-three',
            'is_active' => 'admin.appearance.*',
            'sub' => [
                [
                    "label" => 'icons',
                    'route' => 'admin.appearance.icons.index',
                    'is_active' => 'admin.appearance.icons.index',
                ], [
                    "label" => 'media manager',
                    'route' => 'admin.appearance.media.index',
                    'is_active' => 'admin.appearance.media.index',
                ],
            ]
        ],
        [
            'position' => 51,
            "label" => "settings",
            'icon' => 'gears',
            'is_active' => 'admin.settings.*',
            'permission' => 'admin.setting',
            'sub' => [
                [
                    "label" => 'info',
                    'route' => 'admin.settings.info.index',
                    'is_active' => 'admin.settings.info.index',
                    'permission' => 'admin.info.read',
                ], [
                    "label" => 'logs',
                    'route' => 'admin.settings.logs.show',
                    'is_active' => 'admin.settings.logs.show',
                    'permission' => 'admin.log.show',
                ],
                [
                    "label" => 'caches',
                    'route' => 'admin.settings.caches.index',
                    'is_active' => 'admin.settings.caches.index',
                    'permission' => 'admin.cache.read',
                ],

            ]
        ],
        [
            'position' => 75,
            "label" => "users",
            'icon' => 'users',
            'is_active' => 'admin.users.*',
            'permission' => 'admin.user.read',
            'sub' => [
                [
                    "label" => 'users',
                    'route' => 'admin.users.index',
                    'is_active' => 'admin.users.index',
                    'permission' => 'admin.user.read',
                ],
                [
                    "label" => 'new',
                    'route' => 'admin.users.create',
                    'is_active' => 'admin.users.create',
                    'permission' => 'admin.user.create',
                ],
            ]
        ],
        [
            'position' => 100,
            "label" => "authorization",
            'icon' => 'lock-closed',
            'is_active' => 'admin.authorize.*',
            'permission' => ['admin.permission.read', 'admin.role.read'],
            'sub' => [
                [
                    "label" => 'permissions',
                    'route' => 'admin.authorize.permissions.index',
                    'is_active' => 'admin.authorize.permissions.*',
                    'permission' => 'admin.permission.read',
                ],
                [
                    "label" => 'roles',
                    'route' => 'admin.authorize.roles.index',
                    'is_active' => 'admin.authorize.roles.*',
                    'permission' => 'admin.role.read',
                ],
            ]
        ],
    ],
];
