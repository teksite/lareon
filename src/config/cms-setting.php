<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Path
   |--------------------------------------------------------------------------
   |
   | Main path where lareon (cms) folder placed there.
   |
   */
    "main_path"=>'Lareon',


    /*
   |--------------------------------------------------------------------------
   | Module configuration
   |--------------------------------------------------------------------------
   |
   */
    'cms'=>[
        "directory"=>"CMS",

        'namespace'=>'Lareon\\CMS',
    ],

    'module'=>[
        "manager"=>'\\Lareon\\CMS\\App\\Providers\\ModulesManagerServiceProvider',
    ]
];

