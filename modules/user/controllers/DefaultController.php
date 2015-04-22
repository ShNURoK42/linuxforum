<?php

namespace user\controllers;

use Yii;
use user\models\User;
use user\models\SearchUsers;

class DefaultController extends \yii\web\Controller
{
    /**
     * @param integer $id user profile identificator
     * @return string content
     */
    public function actionView($id)
    {
        $user = User::findOne(['id' => $id]);

        return $this->render('view', ['user' => $user]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $model = new SearchUsers();
        $dataProvider = $model->search(Yii::$app->request->get());
        $users = $dataProvider->getModels();

        return $this->render('list', [
            'model' => $model,
            'users' => $users,
            'dataProvider' => $dataProvider
        ]);
    }
}