<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\forms\ProfileForm;
use app\models\User;

class UserProfileController extends \app\components\BaseController
{
    public function actionIndex($id)
    {
        /** @var User $user */
        $user = User::findOne(['id' => $id]);

        if (!Yii::$app->getUser()->can('updateProfile', ['user' => $user])) {
            throw new NotFoundHttpException;
        }

        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $user->about = $model->message;
                $user->save();
            }
        } else {
            $model->message = $user->about;
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
        ]);
    }
}