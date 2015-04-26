<?php

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'name' => 'SCV System',
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    //'language' => 'en-US',
    'controllerNamespace' => 'frontend\controllers',
    'viewPath' => dirname(__DIR__) . '/modules/frontend/views',

    /**
     * Path aliases
     */
    'aliases' => [
        '@ad' => dirname(__DIR__) . '/modules/ad',
        '@captcha' => dirname(__DIR__) . '/modules/captcha',
        '@editor' => dirname(__DIR__) . '/modules/editor',
        '@forum' => dirname(__DIR__) . '/modules/forum',
        '@frontend' => dirname(__DIR__) . '/modules/frontend',
        '@notify' => dirname(__DIR__) . '/modules/notify',
        '@post' => dirname(__DIR__) . '/modules/post',
        '@role' => dirname(__DIR__) . '/modules/role',
        '@topic' => dirname(__DIR__) . '/modules/topic',
        '@user' => dirname(__DIR__) . '/modules/user',
    ],

    /**
     * Preload modules
     */
    'bootstrap' => [
        'log',
    ],

    /**
     * Modules list
     */
    'modules' => [
        'ad' => [
            'class' => 'ad\Module',
        ],
        'captcha' => [
            'class' => 'captcha\Module',
        ],
        'editor' => [
            'class' => 'editor\Module',
        ],
        'forum' => [
            'class' => 'forum\Module',
        ],
        'frontend' => [
            'class' => 'frontend\Module',
        ],
        'notify' => [
            'class' => 'notify\Module',
        ],
        'post' => [
            'class' => 'post\Module',
        ],
        'role' => [
            'class' => 'role\Module',
        ],
        'topic' => [
            'class' => 'topic\Module',
        ],
        'user' => [
            'class' => 'user\Module',
        ],
    ],

    /**
     * Components
     */
    'components' => [
        'urlManager' => [
            'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
                /**
                 * frontend module routes
                 */
                '/' => 'frontend/default/index',
                'markdown' => 'frontend/default/markdown',
                'terms' => 'frontend/default/terms',
                'feedback' => 'frontend/default/feedback',
                /**
                 * user module routes
                 */
                'users/page/<page:\d+>' => 'user/default/list',
                'users' => 'user/default/list',
                'user/<id:\d+>' => 'user/default/view',
                // IdentityController
                'login' => 'user/identity/login',
                'logout' => 'user/identity/logout',
                'registration' => 'user/identity/registration',
                // ForgetController
                'forget' => 'user/forget/index',
                'forget/change' => 'user/forget/change',
                // SettingsController
                'user/<id:\d+>/settings' => 'user/settings/profile',
                'user/<id:\d+>/settings/profile' => 'user/settings/profile',
                'user/<id:\d+>/settings/notifications' => 'user/settings/notifications',
                'settings' => 'user/settings/profile',
                'settings/profile' => 'user/settings/profile',
                'settings/notifications' => 'user/settings/notifications',
                /**
                 * forum module routes
                 */
                'forum/<id:\d+>/page/<page:\d+>' => 'forum/default/view',
                'forum/<id:\d+>' => 'forum/default/view',
                /**
                 * topic module routes
                 */
                'forum/<id:\d+>/topic/new' => 'topic/default/create',
                'post/<id:\d+>' => 'topic/post/view',
                'topic/<id:\d+>/page/<page:\d+>' => 'topic/default/view',
                'topic/<id:\d+>' => 'topic/default/view',
                // SearchController
                'search/active_topics' => 'topic/search/view-active-topics',
                'search/unanswered_topics' => 'topic/search/view-unanswered-topics',
                'search/ownpost_topics' => 'topic/search/view-ownpost-topics',
                /**
                 * post module routes
                 */
                'post/preview' => 'post/default/preview',
                'post/update' => 'post/default/update',
                'topic/<id:\d+>/post/new' => 'post/default/create',
                'post/delete/<id:\d+>' => 'post/default/delete',
                /**
                 * notify module routes
                 */
                'notifications' => 'notify/default/view',
                /**
                 * captcha module routes
                 */
                'captcha' => 'captcha/default/index',
                /**
                 * editor module routes
                 */
                'editor/mention' => 'editor/default/mention',

            ],
        ],
        'authManager' => [
            'class' => 'role\components\AuthManager',
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
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'class' => 'app\components\User',
            'identityClass' => 'user\models\User',
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
            'errorAction' => 'frontend/default/error',
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
