<?php

namespace topic;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'topic\controllers';

    public function init()
    {

        \topic\TopicAsset::register(\Yii::$app->getView());

        parent::init();
    }
}
