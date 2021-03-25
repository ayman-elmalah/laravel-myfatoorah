<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Myfatoorah mode
    |--------------------------------------------------------------------------
    |
    | This option controls the mode for myfatoorah service
    |
    | Supported: "session", "token"
    |
    */

    'mode' => env('MYFATOORAH_MODE', "test"),

    /*
    |--------------------------------------------------------------------------
    | Myfatoorah token
    |--------------------------------------------------------------------------
    |
    | This option controls the token for myfatoorah service
    |
    */

    'token' => env('MYFATOORAH_TOKEN'),
];
