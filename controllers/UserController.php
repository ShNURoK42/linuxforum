<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use app\models\User;
use app\models\forms\ForgetForm;
use app\models\forms\RegistrationForm;
use app\models\forms\LoginForm;
use app\models\search\SearchUsers;

/**
 * Class UserController
 */
class UserController extends \app\components\BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'register', 'forget', 'forget-change'],
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

    /**
     * @return string
     */
    public function actionRegistration()
    {
        $model = new RegistrationForm();
        $model->setScenario('registration');

        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            return $this->render('/site/info', [
                'params' => [
                    'name' => Yii::t('app/common', 'Info'),
                    'message' => Yii::t('app/register', 'Success info') . ' ' . Html::a(Yii::$app->config->get('o_webmaster_email'), null, ['href' => 'mailto:' . Yii::$app->config->get('o_webmaster_email')]) . '.',
                ]
            ]);
        }

        return $this->render('registration', ['model' => $model]);
    }

    /**
     * Password recovery action.
     * @return string
     */
    public function actionForget()
    {
        $model = new ForgetForm(['scenario' => 'email']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->isRequestFlud()) {
                return $this->render('/site/info', [
                    'params' => [
                        'name' => Yii::t('app/common', 'Info'),
                        'message' => Yii::t('app/forget', 'Email flood'),
                    ]
                ]);
            }

            if ($model->recoveryPassword()) {
                return $this->render('/site/info', [
                    'params' => [
                        'name' => Yii::t('app/common', 'Info'),
                        'message' => Yii::t('app/forget', 'Email sent message') . ' ' . Html::a(Yii::$app->config->get('o_webmaster_email'), null, ['href' => 'mailto:' . Yii::$app->config->get('o_webmaster_email')]) . '.',
                    ]
                ]);
            }
        }

        return $this->render('forget', ['model' => $model]);
    }

    /**
     * Updated user password action.
     * @return string
     */
    public function actionForgetChange()
    {
        $model = new ForgetForm(['scenario' => 'token']);

        if (!$model->load(Yii::$app->request->get(), '') || !$model->user) {
            throw new NotFoundHttpException();
        }

        if ($model->updatePassword()) {
            $params = [
                'name' => Yii::t('app/common', 'Info'),
                'message' => Yii::t('app/forget', 'Password updated'),
            ];

            return $this->render('/site/info', ['params' => $params]);
        } else {
            $params = [
                'name' => Yii::t('app/common', 'Info'),
                'message' => Yii::t('app/forget', 'Key expired') . ' ' . Html::a(Yii::$app->config->get('o_webmaster_email'), null, ['href' => 'mailto:' . Yii::$app->config->get('o_webmaster_email')]) . '.',
            ];

            return $this->render('/site/info', ['params' => $params]);
        }
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