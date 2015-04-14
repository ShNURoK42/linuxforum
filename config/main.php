<?php

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'name' => 'SCV System',

    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    //'language' => 'en-US',

    'bootstrap' => [
        'log',
    ],

    'components' => [
        'authManager' => [
            'class' => 'app\components\auth\AuthManager',
        ],
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
                'markdown' => 'site/markdown',
                'terms' => 'site/terms',
                'captcha' => 'site/captcha',
                'feedback' => 'site/feedback',

                // UserController
                'login' => 'user/login',
                'logout' => 'user/logout',
                'registration' => 'user/registration',
                'forget' => 'user/forget',
                'forget/change' => 'user/change',
                'users/page/<page:\d+>' => 'user/list',
                'users' => 'user/list',
                'user/<id:\d+>' => 'user/view',

                // UserProfileController
                'user/<id:\d+>/settings' => 'user-profile/index',

                // ForumController
                'forum/<id:\d+>/page/<page:\d+>' => 'forum/view',
                'forum/<id:\d+>' => 'forum/view',

                // TopicController
                'forum/<id:\d+>/topic/new' => 'topic/create',
                'topic/<id:\d+>/page/<page:\d+>' => 'topic/view',
                'topic/<id:\d+>' => 'topic/view',

                // PostController
                'post/<id:\d+>' => 'post/view',
                'post/preview' => 'post/preview',
                'post/mention' => 'post/mention',
                'post/update' => 'post/update',
                'topic/<id:\d+>/post/new' => 'post/create',
                'post/delete/<id:\d+>' => 'post/delete',

                // SearchController
                'search/active_topics' => 'search/view-active-topics',
                'search/unanswered_topics' => 'search/view-unanswered-topics',
                'search/ownpost_topics' => 'search/view-ownpost-topics',

                // NotoficationController
                'notifications' => 'notification/view',

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
                        'app/register' => 'registration.php',
                        'app/topic' => 'topic.php',
                        'app/userlist' => 'userlist.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'app\components\Mailer',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                        'from' => ['log@linuxforum.ru'],
                        'to' => ['support@linuxforum.ru'],
                        'subject' => 'Database errors at linuxforum.ru',
                    ],
                ],
            ],
        ],
    ],
];
