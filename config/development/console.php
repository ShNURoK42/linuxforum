<?php

return [
    'controllerMap' => [
        'stubs' => [
            'class' => 'bazilio\stubsgenerator\StubsController',
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=linuxforum',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ],
    ],
];
