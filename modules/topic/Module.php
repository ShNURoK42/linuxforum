<?php

namespace topic;

use topic\TopicAsset;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'topic\controllers';

    public function init()
    {
        parent::init();

        TopicAsset::register(\Yii::$app->getView());
    }
}
