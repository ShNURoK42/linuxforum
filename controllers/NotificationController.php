<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\UserMention;

/**
 * Class NotificationController
 */
class NotificationController extends \app\components\BaseController
{
    public function actionView()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            $user = \Yii::$app->getUser()->getIdentity();

            $userMentions = UserMention::find()
                ->with('topic')
                ->where(['mention_user_id' => $user->id])
                ->all();

            return $this->render('view', [
                'userMentions' => $userMentions,
                'user' => $user,
            ]);
        }

        throw new NotFoundHttpException();
    }
}
