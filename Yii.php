<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = include(__DIR__ . '/vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property \role\components\AuthManager $authManager
 * @property \common\components\View $view
 *
 * @method \role\components\AuthManager getAuthManager()
 * @method \common\components\View getView()
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \common\components\Config $config
 * @property \common\components\User $user
 * @property \common\components\Formatter $formatter
 *
 * @method \common\components\Config getConfig()
 * @method \common\components\User getUser()
 * @method \common\components\Formatter getFormatter()
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 * @property \common\components\Mailer $mailer
 *
 * @method \common\components\Mailer getMailer()
 */
class ConsoleApplication extends yii\console\Application
{
}