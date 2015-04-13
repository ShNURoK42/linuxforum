<?php

namespace app\components;

use Yii;
use app\models\Online;

class BaseController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $ip = ip2long(Yii::$app->getRequest()->getUserIP());

            $online = Online::find()
                ->where(['user_ip' => $ip])
                ->one();

            if (!$online instanceof Online) {
                $online = new Online();
            }

            $online->vizited_at = time();
            $online->user_ip = $ip;

            if (!Yii::$app->getUser()->getIsGuest()) {
                $online->user_id = Yii::$app->getUser()->getIdentity()->getId();
            } else {
                $online->user_id = 0;
            }

            $online->save();
            Online::deleteInactiveUsers();

            return true;
        } else {
            return false;
        }
    }
}