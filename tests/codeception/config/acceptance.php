<?php
/**
 * Application configuration for acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/main.php'),
    require(__DIR__ . '/../../../config/development/main.php'),
    require(__DIR__ . '/config.php'),
    [

    ]
);
