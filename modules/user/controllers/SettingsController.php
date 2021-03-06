<?php

namespace user\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use user\models\NotifyForm;
use user\models\ProfileForm;
use user\models\User;

class SettingsController extends \yii\web\Controller
{
    public function actionProfile($id = 0)
    {
        if (Yii::$app->request->get('id') == 0 && !Yii::$app->getUser()->getIsGuest()) {
            $id = Yii::$app->getUser()->getIdentity()->getId();
        }

        /** @var User $user */
        $user = User::findOne(['id' => $id]);

        if (!$user || !Yii::$app->getUser()->can('updateProfile', ['user' => $user])) {
            throw new NotFoundHttpException;
        }

        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user->about = $model->message;
                $user->timezone = $model->timezone;
                $user->save();
            }
        } else {
            $model->message = $user->about;
            $model->timezone = $user->timezone;
        }

        return $this->render('profile', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    public function actionNotifications($id = 0)
    {
        if (Yii::$app->request->get('id') == 0 && !Yii::$app->getUser()->getIsGuest()) {
            $id = Yii::$app->getUser()->getIdentity()->getId();
        }

        /** @var User $user */
        $user = User::findOne(['id' => $id]);

        if (!$user || !Yii::$app->getUser()->can('updateProfile', ['user' => $user])) {
            throw new NotFoundHttpException;
        }

        $model = new NotifyForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $user->notify_mention_email = (int) $model->notify_mention_email;
                $user->notify_mention_web = (int) $model->notify_mention_web;
                $user->save();
            }
        } else {
            $model->notify_mention_email = $user->notify_mention_email;
            $model->notify_mention_web = $user->notify_mention_web;
        }

        return $this->render('notifications', [
            'user' => $user,
            'model' => $model,
        ]);
    }
}