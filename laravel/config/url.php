<?php

return [

    /*
    |--------------------------------------------------------------------------
    | External urls
    |--------------------------------------------------------------------------
    |
    | This file is for storing external urls
    | including external services part of this application
    | !!! don't use a final slash in the url address
    |
    */

    'limitless-analytics' =>
        env("API_ANALYTICS_PROTOCOL") . '://' .
        env("API_ANALYTICS_HOSTNAME") . ':' .
        env("API_ANALYTICS_PORT") . '/api/v1.0',
];