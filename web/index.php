<?php

require(__DIR__ . '/../vendor/autoload.php');

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '176.196.43.102') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../config/main.php'),
        require(__DIR__ . '/../config/development/main.php')
    );
} else {
    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../config/main.php'),
        require(__DIR__ . '/../config/prodaction/main.php')
    );
}

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$application = new yii\web\Application($config);
$application->run();
