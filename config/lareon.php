<?php

return [
    /*
     |--------------------------------------------------------------------------
     | CMS CONFIG
     |--------------------------------------------------------------------------
     |
     */
    "cms"=>[
        /*
         |----------------------------------------------------------------------
         | CMS Routes
         |----------------------------------------------------------------------
         |
         | specify which route files should be registered, along with their corresponding middleware and prefix
         |
         */
        "routes"=>
           [
            //Admin Routes
           'admin.web' => [
              'path' => 'admin/web.php',
              'middleware' => ['web','auth','verified','can:admin'],
              'prefix' => 'tkadmin',
              'name' => 'admin.',  //DO NOT CHANGE IT,
           ],
           'admin.ajax' => [
              'path' => 'admin/ajax.php',
              'middleware' => ['api','web','auth','verified'],
              'prefix' => 'tkadmin/ajax',
              'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
           ],
           'admin.api.v1' => [
              'path' => 'panel/api.php',
              'middleware' => ['api','auth','verified'],
              'prefix' => 'panel/api/v1',
              'name' => 'panel.api.v1.',  //DO NOT CHANGE IT,
           ],

            //Panel Routes
           'panel.web' => [
              'path' => 'panel/web.php',
              'middleware' => ['web','auth','verified'],
              'prefix' => 'panel',
              'name' => 'panel.',  //DO NOT CHANGE IT,
           ],
           'panel.ajax' => [
              'path' => 'panel/ajax.php',
              'middleware' => ['api','web','auth','verified'],
              'prefix' => 'panel/ajax',
              'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
           ],
           'panel.api.v1' => [
              'path' => 'panel/api.php',
              'middleware' => ['api','auth','verified'],
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
              'middleware' => ['api','web'],
              'prefix' => 'ajax',
              'name' => 'ajax.',  //DO NOT CHANGE IT,
           ],
           'client.api.v1' => [
              'path' => 'api.php',
              'middleware' => ['api'],
              'prefix' => 'api/v1',
              'name' => '',  //DO NOT CHANGE IT,
           ],

            //AUTH Routes

           'auth.web' => [
              'path' => 'auth/web.php',
              'middleware' => ['web'],
              'prefix' => 'panel',
              'name' => 'panel.',  //DO NOT CHANGE IT,
           ],
           'auth.ajax' => [
              'path' => 'auth/ajax.php',
              'middleware' => ['api','web'],
              'prefix' => 'panel/ajax',
              'name' => 'admin.ajax.',  //DO NOT CHANGE IT,
           ],
           'auth.api.v1' => [
              'path' => 'auth/api.php',
              'middleware' => ['api'],
              'prefix' => 'panel/api/v1',
              'name' => 'panel.api.v1.',  //DO NOT CHANGE IT,
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
        "sitemap"=>[
            'file' => env('SITEMAP_FILE','index'),   //index, single

            'crawl' => env('SITEMAP_CRAWL','database'), // database , auto
        ]
    ],

    /*
       |--------------------------------------------------------------------------
       | Modules
       |--------------------------------------------------------------------------
       |
       */
    'modules'=>[
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
               'middleware' => ['api','web'],
               'prefix' => 'ajax',
               'name' => 'ajax.',
           ],
           'admin.web' => [
               'path' => 'admin/web.php',
               'middleware' => ['web','auth','verified'],
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
               'middleware' => ['web','api','auth','verified'],
               'prefix' => 'tkadmin/ajax',
               'name' => 'admin.ajax.',
           ],
           'panel.web' => [
             'path' => 'panel/web.php',
             'middleware' => ['web','auth','verified'],
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
               'middleware' => ['web','api','auth','verified'],
               'prefix' => 'panel/ajax',
               'name' => 'panel.ajax.',
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
    'comment'=>[
        'allow'=>env('COMMENT_ALLOW','any'), //auth (only registered and login users) and any (for anyone)
        'confirmation'=>true, // true -> comments should be confirmed first , false -> all comments confirmed
        'unconfirmed_visibility'=>true,
        'limit'=>5,
        'notifyEmail'=>[
            'sina.zangiband@gmail.com'
        ]

    ]



];
