<?php



return [



    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */



    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],



    /*

    |--------------------------------------------------------------------------

    | Authentication Guards

    |--------------------------------------------------------------------------

    |

    | Next, you may define every authentication guard for your application.

    | Of course, a great default configuration has been defined for you

    | here which uses session storage and the Eloquent user provider.

    |

    | All authentication drivers have a user provider. This defines how the

    | users are actually retrieved out of your database or other storage

    | mechanisms used by this application to persist your user's data.

    |

    | Supported: "session", "token"

    |

    */



    'guards' => [

        'web' => [

            'driver' => 'session',

            'provider' => 'users',

        ],



        'api' => [

            'driver' => 'token',

            'provider' => 'users',

        ],



        'admin' => [

            'driver' => 'session',

            'provider' => 'admins',

        ],

        'livreur' => [

            'driver' => 'session',

            'provider' => 'livreurs',

        ],

        'production' => [
            'driver' => 'session',
            'provider' => 'productions',
        ],
        'depot' => [
            'driver' => 'session',
            'provider' => 'depots',
        ],


        
    ],






    'providers' => [

        'users' => [

            'driver' => 'eloquent',

            'model' => App\User::class,

        ],



        'admins' => [

            'driver' => 'eloquent',

            'model' => App\Admin::class,

        ],

        'depots' => [

            'driver' => 'eloquent',

            'model' => App\Depot::class,

        ],

        'productions' => [

            'driver' => 'eloquent',

            'model' => App\Production::class,

        ],

        'livreurs' => [

            'driver' => 'eloquent',

            'model' => App\Livreur::class,

        ],



        // 'users' => [

        //     'driver' => 'database',

        //     'table' => 'users',

        // ],

    ],
    'passwords' => [

        'users' => [

            'provider' => 'users',

            'table' => 'password_resets',

            'expire' => 60,

        ],



        'admins' => [

            'provider' => 'admins',

            'table' => 'password_resets',

            'expire' => 60,

        ],

        

        'livreurs' => [

            'provider' => 'livreurs',

            'table' => 'password_resets',

            'expire' => 60,

        ],

        'productions' => [
            'provider' => 'productions',
            'table' => 'password_resets',
            'expire' => 60,

        ],

        'depots' => [
            'provider' => 'depots',
            'table' => 'password_resets',
            'expire' => 60,

        ],

    ],

];

