<?php

namespace app\controllers;

use app\models\User;

class UserProfileController extends \app\components\BaseController
{
    public function actionIndex($id)
    {
        $user = User::findOne(['id' => $id]);

        return $this->render('index', ['user' => $user]);
    }
}