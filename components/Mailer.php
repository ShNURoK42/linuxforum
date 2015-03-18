<?php

namespace app\components;

use Yii;
use yii\swiftmailer\Mailer as YiiMailer;

class Mailer extends YiiMailer
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setViewPath($this->getViewPath() . '/' .  Yii::$app->language);
    }
}