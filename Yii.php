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
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 *
 * @property \app\components\ConfigManager $config
 * @property \app\components\Security $security
 * @property \app\components\User $user
 * @property \app\components\View $view
 * @property \app\components\Formatter $formatter
 *
 * @method \app\components\ConfigManager getConfig()
 * @method \app\components\Security getSecurity()
 * @method \app\components\User getUser()
 * @method \app\components\View getView()
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