<?php

return [
    'id' => 'aplication',
    'basePath' => dirname(__DIR__),
    'name' => 'SCV System',

    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    //'language' => 'en-US',

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'config' => [
            'class' => 'app\components\Config'
        ],
        'formatter' => [
            'class' => 'app\components\Formatter'
        ],
        'urlManager' => [
            'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
                // SiteController
                '/' => 'site/index',
                'rules' => 'site/rules',

                // UserController
                'login' => 'user/login',
                'logout' => 'user/logout',
                'register' => 'user/register',
                'forget' => 'user/forget',
                'forget/change' => 'user/forget-change',
                'users/page/<page:\d+>' => 'user/list',
                'users' => 'user/list',
                'user/<id:\d+>' => 'user/view',

                // ForumController
                'forum/<id:\d+>/page/<page:\d+>' => 'forum/view',
                'forum/<id:\d+>' => 'forum/view',

                // TopicController
                'forum/<id:\d+>/topic/new' => 'topic/create',
                'topic/<id:\d+>/page/<page:\d+>' => 'topic/view',
                'topic/<id:\d+>' => 'topic/view',

                // PostController
                'post/<id:\d+>' => 'post/view',
                'topic/<id:\d+>/post/new' => 'post/create',
                'post/delete/<id:\d+>' => 'post/delete',

                // SearchController
                'search/active_topics' => 'search/view-active-topics',

                // Admin
                'admin' => 'admin-index/index',
            ],
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'view' => [
            'class' => 'app\components\View',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app/common' => 'common.php',
                        'app/forget' => 'forget.php',
                        'app/form' => 'form.php',
                        'app/forum' => 'forum.php',
                        'app/index' => 'index.php',
                        'app/login' => 'login.php',
                        'app/profile' => 'profile.php',
                        'app/register' => 'register.php',
                        'app/topic' => 'topic.php',
                        'app/userlist' => 'userlist.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'app\components\Mailer',
        ],
        'security' => [
            'class' => 'app\components\Security',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
];
