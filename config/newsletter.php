<?php

return [

    /*
     * The driver to use to interact with MailChimp API.
     * You may use "log" or "null" to prevent calling the
     * API directly from your environment.
     */
    'driver' => env('MAILCHIMP_DRIVER', 'api'),

    'apiKey' => env('MAILCHIMP_APIKEY'),

    'defaultListName' => 'subscribers',

    'lists' => [
        'subscribers' => [
            'id' => env('MAILCHIMP_LIST_ID'),
        ],
    ],

    'ssl' => true,
];
