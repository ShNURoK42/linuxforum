<?php

namespace user\controllers;

use Yii;
use yii\filters\AccessControl;
use user\models\RegistrationForm;
use user\models\LoginForm;

class IdentityController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'registration'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionRegistration()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            return $this->render('@frontend/views/default/info', [
                'params' => [
                    'name' => Yii::t('app/register', 'Important'),
                    'message' => Yii::t('app/register', 'Success info'),
                ]
            ]);
        }

        return $this->render('registration', ['model' => $model]);
    }

    /**
     * Login application action.
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout application action.
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}