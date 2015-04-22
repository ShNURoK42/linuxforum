<?php

namespace notify\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use notify\models\UserMention;

/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    public function actionView()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            $user = \Yii::$app->getUser()->getIdentity();

            $userMentions = UserMention::find()
                ->with('topic')
                ->where(['mention_user_id' => $user->id])
                ->andWhere(['status' => UserMention::MENTION_SATUS_UNVIEWED])
                ->all();

            return $this->render('view', [
                'userMentions' => $userMentions,
                'user' => $user,
            ]);
        }

        throw new NotFoundHttpException();
    }
}
