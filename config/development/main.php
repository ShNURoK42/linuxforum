<?php

return [
    'bootstrap' => [
        'debug',
        'gii',
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
        ],
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'secret_key_here',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=linuxforum',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ],
        'log' => [
            'traceLevel' => 0,
        ],
    ],
];
