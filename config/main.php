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
        '@common' => dirname(__DIR__) . '/modules/common',
        '@editor' => dirname(__DIR__) . '/modules/editor',
        '@frontend' => dirname(__DIR__) . '/modules/frontend',
        '@notify' => dirname(__DIR__) . '/modules/notify',
        '@post' => dirname(__DIR__) . '/modules/post',
        '@role' => dirname(__DIR__) . '/modules/role',
        '@sidebar' => dirname(__DIR__) . '/modules/sidebar',
        '@tag' => dirname(__DIR__) . '/modules/tag',
        '@topic' => dirname(__DIR__) . '/modules/topic',
        '@user' => dirname(__DIR__) . '/modules/user',
    ],

    /**
     * Preload modules
     */
    'bootstrap' => [
        'log',
        'common\Bootstrap',
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
        'common' => [
            'class' => 'common\Module',
        ],
        'editor' => [
            'class' => 'editor\Module',
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
        'sidebar' => [
            'class' => 'sidebar\Module',
        ],
        'tag' => [
            'class' => 'tag\Module',
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
                 * frontend module
                 */
                '/page/<page:\d+>' => 'frontend/default/index',
                '/' => 'frontend/default/index',
                'markdown' => 'frontend/default/markdown',
                'terms' => 'frontend/default/terms',
                'feedback' => 'frontend/default/feedback',
                /**
                 * user module
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
                 * tag module
                 */
                'ajax/tag' => 'tag/ajax/tag',
                /**
                 * topic module
                 */
                'topic/<id:\d+>/page/<page:\d+>' => 'topic/default/view',
                'topic/<id:\d+>' => 'topic/default/view',
                'topics/tagged/<name:\w+>/page/<page:\d+>' => 'topic/default/list',
                'topics/tagged/<name:\w+>' => 'topic/default/list',
                'topics/page/<page:\d+>' => 'topic/default/list',
                'topics' => 'topic/default/list',
                'topic/create' => 'topic/default/create',
                /**
                 * post module
                 */
                'post/<id:\d+>' => 'post/default/view',
                'post/create' => 'post/default/create',
                'post/preview' => 'post/default/preview',
                'post/update' => 'post/default/update',
                'topic/<id:\d+>/post/new' => 'post/default/create',
                /**
                 * notify module
                 */
                'notifications' => 'notify/default/view',
                /**
                 * captcha module
                 */
                'captcha' => 'captcha/default/index',
                /**
                 * editor module
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
            'class' => 'common\components\Config'
        ],
        'formatter' => [
            'class' => 'common\components\Formatter'
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ],
        'user' => [
            'class' => 'common\components\User',
            'identityClass' => 'user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
        ],
        'view' => [
            'class' => 'common\components\View',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
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
            'class' => 'common\components\Mailer',
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
