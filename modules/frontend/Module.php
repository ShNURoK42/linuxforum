<?php

namespace frontend;

use Yii;
use user\models\UserOnline;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\controllers';

    public function init()
    {
        parent::init();

        $ip = ip2long(Yii::$app->getRequest()->getUserIP());

        $online = UserOnline::find()
            ->where(['user_ip' => $ip])
            ->one();

        if (!$online instanceof UserOnline) {
            $online = new UserOnline();
        }

        $online->vizited_at = time();
        $online->user_ip = $ip;

        if (!Yii::$app->getUser()->getIsGuest()) {
            $online->user_id = Yii::$app->getUser()->getIdentity()->getId();
        } else {
            $online->user_id = 0;
        }

        $online->save();
        UserOnline::deleteInactiveUsers();

        return true;
    }
}
