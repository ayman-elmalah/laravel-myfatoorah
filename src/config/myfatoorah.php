<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MyFatoorah Mode
    |--------------------------------------------------------------------------
    |
    | This option controls the mode for MyFatoorah service
    |
    | Supported: "test", "live", "live-sa"
    |
    */

    'mode' => env('MYFATOORAH_MODE', "test"),

    /*
    |--------------------------------------------------------------------------
    | MyFatoorah Token
    |--------------------------------------------------------------------------
    |
    | This option controls the token for MyFatoorah service
    |
    */

    'token' => env('MYFATOORAH_TOKEN'),
];
