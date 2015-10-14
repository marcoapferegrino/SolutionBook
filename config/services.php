<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'SolutionBook\User',
		'secret' => '',
	],

    'facebook' => [
        'client_id' => '887937647909883',
        'client_secret' => '66d31cd655973c9d5c2a252e0e2d6ff1',
        'redirect' => 'http://solution.book/login/facebook',
    ],

    'github' => [
        'client_id' => '7aacfd34e493b4f825c8',
        'client_secret' => '7926e6ceeaa899f39c337e4eeeb7b26e19776024',
        'redirect' => 'http://solution.book/login/github',
    ],

];
