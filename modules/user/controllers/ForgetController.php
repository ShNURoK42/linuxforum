<?php

namespace user\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

use user\models\ForgetForm;

class ForgetController extends \yii\web\Controller
{
    /**
     * Password recovery action.
     * @return string
     */
    public function actionIndex()
    {
        $model = new ForgetForm(['scenario' => 'email']);

        if ($model->load(Yii::$app->request->post()) && $model->recovery()) {
            return $this->render('@frontend/views/default/info', [
                'params' => [
                    'name' => Yii::t('app/common', 'Info'),
                    'message' => Yii::t('app/forget', 'Email sent message') . ' ' . Html::a(Yii::$app->config->get('support_email'), null, ['href' => 'mailto:' . Yii::$app->config->get('support_email')]) . '.',
                ]
            ]);
        }

        return $this->render('forget', ['model' => $model]);
    }

    /**
     * Updated user password action.
     * @return string
     */
    public function actionChange()
    {
        $model = new ForgetForm(['scenario' => 'token']);

        if (!$model->load(Yii::$app->request->get(), '') || !$model->user) {
            throw new NotFoundHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            return $this->render('@frontend/views/default/info', [
                'params' => [
                    'name' => Yii::t('app/common', 'Info'),
                    'message' => Yii::t('app/forget', 'Password updated'),
                ]
            ]);
        }

        return $this->render('change', ['model' => $model]);
    }
}