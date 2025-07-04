# Lareon CMS

A simple, fast, and flexible Content Management System (CMS) built on Laravel, leveraging the `teksite/module` package to provide modular functionality. Lareon CMS can manage modules created by `teksite/module` with the `type` set to `lareon` in `bootstrap/modules.php`.

## Table of Contents
- [About](#about)
- [Author](#author)
- [Contact](#contact)
- [Installation](#installation)
- [Usage](#usage)
    - [Commands](#commands)
    - [Configuration](#configuration)
- [Features](#features)
    - [Sitemap](#sitemap)
    - [Comments](#comments)
    - [Captcha](#captcha)
    - [OAuth](#oauth)
    - [Notifications](#notifications)
- [Credits](#credits)
- [Related Packages](#related-packages)
- [License](#license)
- [Support](#support)

## About
**Lareon CMS** is designed to streamline CMS development with a modular architecture. It integrates seamlessly with the `teksite/module` package to manage modules and provides a robust set of features for building dynamic, scalable content management systems. The CMS supports customizable routes, middleware, sitemaps, comments, CAPTCHA, OAuth, and notifications.

## Author
Developed by **Sina Zangiband**.

## Contact
- Website: [teksite.net](https://teksite.net)
- Email: [sina.zangiband@gmail.com](mailto:sina.zangiband@gmail.com)

## Installation

### Compatibility
| **Laravel** | **Package** |
|-------------|-------------|
| 11.x        | ^1.0        |
| 12.x        | ^2.0        |

### Step 1: Install via Composer
Run the following command in your terminal:
```bash
composer require teksite/lareon
```

#### Note on wikimedia/composer-merge-plugin
If prompted with:
```
Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?] 
```
Press `y` and Enter. This plugin merges `composer.json` files from modules and CMS.

### Step 2: Register the Service Provider
> **Note**: Laravel 5.5 and above supports auto-discovery, so this step is optional for newer versions.

#### For Laravel 10 and 11
Add the service provider to `bootstrap/providers.php`:
```php
<?php

return [
    // Other providers
    Teksite\Lareon\LareonPackageServiceProvider::class,
];
```

#### For Laravel 5.x and Earlier
Add the service provider to `config/app.php` under the `providers` array:
```php
'providers' => [
    // Other Service Providers
    Teksite\Lareon\LareonPackageServiceProvider::class,
],
```

### Step 3: Install CMS
Install the CMS and set up its core components:
```bash
php artisan lareon:install
```

### Step 4: Publish Configuration (Optional)
Publish the package's configuration file for customization:
```bash
php artisan vendor:publish --provider="Teksite\Lareon\LareonPackageServiceProvider"
```

### Step 5: Update Composer.json
To autoload CMS and module classes, add the following to your `composer.json`:
```json
"extra": {
    "laravel": {
        "dont-discover": []
    },
    "merge-plugin": {
        "include": [
            "Lareon/CMS/composer.json",
            "Lareon/Modules/*/composer.json"
        ]
    }
}
```

### Step 6: Refresh Autoloader
Run the following command to refresh Composer's autoloader:
```bash
composer dump-autoload
```

## Usage

### Commands
Lareon CMS provides commands similar to Laravel and `teksite/module`, prefixed with `cms:`. Examples include:
- Create a model:
  ```bash
  cms:make-model Content --migration
  ```
- Create a controller:
  ```bash
  cms:make-controller ContentController --resource
  ```

### Configuration
The CMS configuration is managed in `config/lareon.php`. You can customize:

```php
<?php

return [
    /*
     |--------------------------------------------------------------------------
     | CMS CONFIG
     |--------------------------------------------------------------------------
     |
     */
    "cms" => [
        /*
         |----------------------------------------------------------------------
         | CMS Routes
         |----------------------------------------------------------------------
         |
         | specify which route files should be registered, along with their corresponding middleware and prefix
         |
         */
        "routes" =>
            [
                //Admin Routes
                'admin.web' => [
                    'path' => 'admin/web.php',
                    'middleware' => ['web', 'auth', 'verified', 'can:admin'],
                    'prefix' => 'tkadmin',
                    'name' => 'admin.',  //DO NOT CHANGE IT,
                ],
                'admin.ajax' => [
                    'path' => 'admin/ajax.php',
                    'middleware' => ['api', 'web', 'auth', 'verified'],
                    'prefix' => 'tkadmin/ajax',
                    'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
                ],
                'admin.api.v1' => [
                    'path' => 'admin/api.php',
                    'middleware' => ['api', 'auth', 'verified'],
                    'prefix' => 'admin/api/v1',
                    'name' => 'admin.api.v1.',  //DO NOT CHANGE IT,
                ],

                //Panel Routes
                'panel.web' => [
                    'path' => 'panel/web.php',
                    'middleware' => ['web', 'auth', 'verified'],
                    'prefix' => 'panel',
                    'name' => 'panel.',  //DO NOT CHANGE IT,
                ],
                'panel.ajax' => [
                    'path' => 'panel/ajax.php',
                    'middleware' => ['api', 'web', 'auth', 'verified'],
                    'prefix' => 'panel/ajax',
                    'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
                ],
                'panel.api.v1' => [
                    'path' => 'panel/api.php',
                    'middleware' => ['api', 'auth', 'verified'],
                    'prefix' => 'panel/api/v1',
                    'name' => 'panel.api.v1.',  //DO NOT CHANGE IT,
                ],

                //Client Routes

                'client.web' => [
                    'path' => 'web.php',
                    'middleware' => ['web'],
                    'prefix' => '',
                    'name' => '',  //DO NOT CHANGE IT,
                ],
                'client.ajax' => [
                    'path' => 'ajax.php',
                    'middleware' => ['api', 'web'],
                    'prefix' => 'ajax',
                    'name' => 'ajax.',  //DO NOT CHANGE IT,
                ],
                'client.api.v1' => [
                    'path' => 'api.php',
                    'middleware' => ['api'],
                    'prefix' => 'api/v1',
                    'name' => 'api.v1.',  //DO NOT CHANGE IT,
                ],

                //AUTH Routes

                'auth.web' => [
                    'path' => 'auth/web.php',
                    'middleware' => ['web'],
                    'prefix' => 'auth',
                    'name' => 'auth.',  //DO NOT CHANGE IT,
                ],
                'auth.ajax' => [
                    'path' => 'auth/ajax.php',
                    'middleware' => ['api', 'web'],
                    'prefix' => 'auth/ajax',
                    'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
                ],
                'auth.api.v1' => [
                    'path' => 'auth/api.php',
                    'middleware' => ['api'],
                    'prefix' => 'auth/api/v1',
                    'name' => 'auth.api.v1.',  //DO NOT CHANGE IT,
                ],

            ],
        /*
         |----------------------------------------------------------------------
         | sitemap ** The sitemap configuration is consistent with the Lareon/SEO module. **
         |----------------------------------------------------------------------
         |
         | sitemap: Defines how URLs should be structured in the sitemap. Choose between:
         |      index: Generates multiple sitemap files for different parts of the app, along with an index file listing all sitemap files.
         |      single: Creates a single sitemap file containing all URLs.
         |
         | sitemap_crawling: Determines how URLs are detected. Choose between: : database , auto
         |
         | Note: The Auto mode only works with the Single file option.
         |
        */
        "sitemap" => [
            'file' => env('SITEMAP_FILE', 'index'),   //index, single

            'crawl' => env('SITEMAP_CRAWL', 'database'), // database , auto
        ]
    ],

    /*
       |--------------------------------------------------------------------------
       | Modules
       |--------------------------------------------------------------------------
       |
       */
    'modules' => [
        /*
       |----------------------------------------------------------------------
       | CMS Routes
       |----------------------------------------------------------------------
       |
       | specify which route files should be registered by the CMS, along with their corresponding middleware and prefix
       |
       */
        'routes' => [
            'client.web' => [
                'path' => 'web.php',
                'middleware' => ['web'],
                'prefix' => '',
                'name' => '',
            ],
            'client.api.v1' => [
                'path' => 'api.php',
                'middleware' => ['api'],
                'prefix' => 'api\\v1',
                'name' => 'api.v1.',
            ],
            'client.ajax' => [
                'path' => 'ajax.php',
                'middleware' => ['api', 'web'],
                'prefix' => 'ajax',
                'name' => 'ajax.',
            ],
            'admin.web' => [
                'path' => 'admin/web.php',
                'middleware' => ['web', 'auth', 'verified'],
                'prefix' => 'tkadmin',
                'name' => 'admin.',
            ],
            'admin.api.v1' => [
                'path' => 'admin/api.php',
                'middleware' => ['api'],
                'prefix' => 'tkadmin/api',
                'name' => 'admin.api.v1.',
            ],
            'admin.ajax' => [
                'path' => 'admin/ajax.php',
                'middleware' => ['web', 'api', 'auth', 'verified'],
                'prefix' => 'tkadmin/ajax',
                'name' => 'admin.ajax.',
            ],
            'panel.web' => [
                'path' => 'panel/web.php',
                'middleware' => ['web', 'auth', 'verified'],
                'prefix' => 'panel',
                'name' => '',
            ],
            'panel.api.v1' => [
                'path' => 'panel/api.php',
                'middleware' => ['api'],
                'prefix' => 'panel/api',
                'name' => 'api.v1.',
            ],
            'panel.ajax' => [
                'path' => 'panel/ajax.php',
                'middleware' => ['web', 'api', 'auth', 'verified'],
                'prefix' => 'panel/ajax',
                'name' => 'panel.ajax.',
            ],
            'auth.web' => [
                'path' => 'auth/web.php',
                'middleware' => ['web'],
                'prefix' => 'auth',
                'name' => 'auth.',
            ],
            'auth.api.v1' => [
                'path' => 'auth/api.php',
                'middleware' => ['api'],
                'prefix' => 'auth/api',
                'name' => 'auth.api.v1.',
            ],
            'auth.ajax' => [
                'path' => 'auth/ajax.php',
                'middleware' => ['web', 'guest'],
                'prefix' => 'auth/ajax',
                'name' => 'auth.ajax.',
            ],
        ],


        /*
        |----------------------------------------------------------------------
        | CMS Routes
        |----------------------------------------------------------------------
        |
        | registering configuration files by the CMS
        |
        */

        'configs' => [
            0 => 'config.php',
            1 => 'search.php',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Comment
    |--------------------------------------------------------------------------
    | This part only works with the comment branch of the teksite/lareon-modules package
    | If the package is not installed or has been modified, it may not function correctly.
    |
    */
    'comment' => [
        'allow' => env('COMMENT_ALLOW', 'any'), //auth (only registered and login users) and any (for anyone)
        'confirmation' => true, // true -> comments should be confirmed first , false -> all comments confirmed
        'unconfirmed_visibility' => true,
        'limit' => 5,
        'notifyEmail' => [
            'sina.zangiband@gmail.com'
        ]

    ],
    /*
    |--------------------------------------------------------------------------
    | Captcha
    |--------------------------------------------------------------------------
    | This part only works with the Captcha branch of the teksite/lareon-modules package
    | If the package is not installed or has been modified, it may not function correctly.
    |
    | local: uses math, and character comparison
    | google: uses I'm not robot checkbox
    |
    */
    'captcha' => [
        'enable' => env('CAPTCHA_ENABLE', true), //true or false =>enable or disable
        'type' => env('CAPTCHA_TYPE', 'local'),
        'google_site_key' => env('GOOGLE_SITE_KEY'),
        'google_secret_key' => env('GOOGLE_SECRET_KEY'),

    ],
    /*
      |--------------------------------------------------------------------------
      | OAUTH
      |--------------------------------------------------------------------------
      | This part only works with the Captcha branch of the teksite/ouath-modules package
      | If the package is not installed or has been modified, it may not function correctly.
      |
      */
    'oauth' => [
        "types" => [
            'google' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],
            'linkedin' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],

            'github' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],
            'gitlab' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],
            'facebook' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],
            'twitter' => [
                'secret_key' => env('GOOGLE_SECRET_KEY'),
                'client_id' => env('GOOGLE_GOOGLE_CLIENT_ID'),
            ],
        ]

    ],
    /*
    |--------------------------------------------------------------------------
    | Notifier (Notification)
    |--------------------------------------------------------------------------
    | This part only works with the Notifier branch of the teksite/lareon-modules package
    | If the package is not installed or has been modified, it may not function correctly.
    |
    */
    'notifier' => [
        'type' => [
            'email',
            'sms',
            'url',
        ],
        'to' => [
            'users',
            'roles',
        ],
    ],
];
```
> some of the features in the config file are work with lareon modules
---
## Credits

- [Sina Zangiband](https://github.com/teksite)

## See
- [teksite/module](https://github.com/teksite/module)
- [teksite/extralaravel](https://github.com/teksite/extralaravel)
- [teksite/handler](https://github.com/teksite/handler)
- [laravel/laravel](https://github.com/laravel/laravel)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

Feel free to reach out if you have any questions or need assistance with this package!
