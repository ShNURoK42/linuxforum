<?php

namespace common\components;

use Yii;

class Mailer extends \yii\swiftmailer\Mailer
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setViewPath('@common/messages/' . Yii::$app->language . '/mail/');
    }
}