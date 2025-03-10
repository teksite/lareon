
# LAREON CMS

## About
this package provide a simple, fast and flexible to develop CMS by using of teksite/module package based on Laravel.


### Author
Sina Zangiband

### Contact
- Website: [laratek.ir](https://laratek.ir)
- Alternate Website: [teksite.net](https://teksite.net)
- email: [sina.zangiband@gmail.com](sina.zangiband@gmail.com)
---

## Installation

| **Laravel** | **package** |
|-------------|-------------|
| 11.0        | ^1.0        |

### Step 1: Install via Composer
Run the following command in your CLI:

```bash
composer require teksite\lareon
```
#### wikimedia/composer-merge-plugin
if you face to ``Do you trust "wikimedia/composer-merge-plugin" to execute code and wish to enable it now? (writes "allow-plugins" to composer.json) [y,n,d,?]
`` press ``y`` and enter. this package is used to recognize and merge composer.json files of modules. 
### Step 2: Register the Service Provider
> **Note:** This step is not required for newer versions of Laravel (5.x and above) but in case:.

#### Laravel 10 and 11
Add the following line to the `bootstrap/providers` file:

```php
Teksite\Lareon\LareonPackageServiceProvider::class,
```

#### Laravel 5.x and earlier
If you are using Laravel 5.x or earlier, register the service provider in the `config/app.php` file under the `providers` array:

```php
'providers' => [
    // Other Service Providers
    Teksite\Lareon\LareonPackageServiceProvider::class,
];
```
### Step 3: Install CMS
To use CMS , and develop or change it install the CMS. 
```bash
php artisan lareon:install"
```


### Step 4: publish Service Provider (optional)
Optionally, publish the package's configuration file by running:

```bash
php artisan vendor:publish --provider="Teksite\Lareon\LareonPackageServiceProvider"
```

### Step 5: add to Composer.json
By default, modules classes are not loaded automatically. You can autoload your modules by adding below codes:


```json
"extra": {
    "laravel": {
        "dont-discover": []
    },
    "merge-plugin": {
        "include": [
            "Lareon/CMS/composer.json"
            "Lareon/Modules/*/composer.json"
        ]
    }
},
```
### Step 6: publish Service Provider (optional)
**Tip: do not forget: `composer dump-autoload` .**

---

## How to work with the package

### commands
commands of CMS are same as laravel command and teksite/module package bt this pattern:
```
cms:make-model <name> <--options>
```
or
```
cms:make-controller <name> <--options>
```

### configs of CMS
In file cms.php (config file of the CMS) you can add/remove/change route files, middlewares or name of the routes or change directory of Databases or other things, We strongly suggest that do not change directories name, paths or Namespaces but yoy are free to change routes files or other such things.
default content of cms.php is

```
<?php

return [
    'modules'=>[

    'lang_path' =>'lang', //translate Json files Directory


    // routes of modules to be scanned
        'routes' => [
           'client.web' => [
               'path' => 'web.php',
               'middleware' => '',
               'prefix' => '',
               'name' => '',
           ],
           'client.api.v1' => [
               'path' => 'api.php',
               'middleware' => 'api',
               'prefix' => 'api\\v1',
               'name' => 'api.v1.',
           ],
           'client.ajax' => [
               'path' => 'ajax.php',
               'middleware' => 'api',
               'prefix' => 'ajax',
               'name' => 'ajax',
           ],
           'admin.web' => [
               'path' => 'admin/web.php',
               'middleware' => 'auth,verified',
               'prefix' => 'tkadmin',
               'name' => '',
           ],
           'admin.api.v1' => [
               'path' => 'admin/api.php',
               'middleware' => 'api',
               'prefix' => 'tkadmin/api',
               'name' => 'api.v1.',
           ],
           'admin.ajax' => [
               'path' => 'admin/ajax.php',
               'middleware' => 'api,auth,verified',
               'prefix' => 'tkadmin/ajax',
               'name' => 'admin.ajax.',
           ],
           'panel.web' => [
             'path' => 'panel/web.php',
             'middleware' => 'auth,verified',
             'prefix' => 'panel',
             'name' => '',
           ],
           'panel.api.v1' => [
               'path' => 'panel/api.php',
               'middleware' => 'api',
               'prefix' => 'panel/api',
               'name' => 'api.v1.',
           ],
           'panel.ajax' => [
               'path' => 'panel/ajax.php',
               'middleware' => 'api,auth,verified',
               'prefix' => 'panel/ajax',
               'name' => 'panel.ajax.',
           ],
         ],


        // configs of modules to be scanned

         'configs' => [
             0 => 'config.php',
             1 => 'search.php',
             2 => 'sitemap.php',
         ],
    ],
];


```



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
