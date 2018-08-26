<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => fnLocalConfigGet('sMailgunDomain'),
        'secret' => fnLocalConfigGet('sMailgunSecret'),
    ],

    'ses' => [
        'key' => fnLocalConfigGet('sSesKey'),
        'secret' => fnLocalConfigGet('sSesSecret'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => fnLocalConfigGet('sSparkpostSecret'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => fnLocalConfigGet('sStripeKey'),
        'secret' => fnLocalConfigGet('sStripeSecret'),
    ],

];
