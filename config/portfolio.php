<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Administrator account
    |--------------------------------------------------------------------------
    |
    | Used by the AdminSeeder and the admin:create command. When no password
    | is provided, a random one is generated and printed once.
    |
    */

    'admin' => [
        'email' => env('ADMIN_EMAIL', 'nganjienzatsi@gmail.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],

];
