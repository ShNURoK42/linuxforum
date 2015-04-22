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
        $this->setViewPath('@app/messages/' . Yii::$app->language . '/mail/');
    }
}