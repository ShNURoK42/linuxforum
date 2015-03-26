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
 * @property \app\components\auth\AuthManager $authManager
 * @property \app\components\Security $security
 * @property \app\components\View $view
 *
 * @method \app\components\auth\AuthManager getAuthManager()
 * @method \app\components\Security getSecurity()
 * @method \app\components\View getView()
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \app\components\Config $config
 * @property \app\components\User $user
 * @property \app\components\Formatter $formatter
 *
 * @method \app\components\Config getConfig()
 * @method \app\components\User getUser()
 * @method \app\components\Formatter getFormatter()
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 * @property \app\components\Mailer $mailer
 *
 * @method \app\components\Mailer getMailer()
 */
class ConsoleApplication extends yii\console\Application
{
}