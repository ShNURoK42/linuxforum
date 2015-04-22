<?php

namespace app\components;

use Yii;
use user\models\UserOnline;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $ip = ip2long(Yii::$app->getRequest()->getUserIP());

            $userOnline = UserOnline::find()
                ->where(['user_ip' => $ip])
                ->one();

            if (!$userOnline instanceof UserOnline) {
                $userOnline = new UserOnline();
            }

            $userOnline->vizited_at = time();
            $userOnline->user_ip = $ip;

            if (!Yii::$app->getUser()->getIsGuest()) {
                $userOnline->user_id = Yii::$app->getUser()->getIdentity()->getId();
            } else {
                $userOnline->user_id = 0;
            }

            $userOnline->save();
            UserOnline::deleteInactiveUsers();

            return true;
        } else {
            return false;
        }
    }
}