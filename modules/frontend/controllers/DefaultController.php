<?php

namespace frontend\controllers;

use Yii;
use yii\web\HttpException;
use frontend\models\FeedbackForm;
use post\models\Post;

/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'testLimit' => 1,
                'offset' => -2,
                'padding' => 0,
                'width' => 200,
                'height' => 50,
                'minLength' => 4,
                'maxLength' => 7,
                'transparent' => true,
                'foreColor' => 0x2A6496,
                //'fixedVerifyCode' => 'test',
            ],
        ];
    }

    /**
     * This action render the index page.
     * @return string
     */
    public function actionIndex()
    {
        return $this->run('/topic/default/list', ['page' => 0]);
    }

    /**
     * This action render the feedback page.
     * @return string
     */
    public function actionFeedback()
    {
        $model = new FeedbackForm();
        if ($model->load(Yii::$app->request->post()) && $model->feedback()) {
            return $this->goBack();
        } else {
            return $this->render('feedback', ['model' => $model]);
        }
    }

    /**
     * This action render the rule page.
     * @return string
     */
    public function actionTerms()
    {
        return $this->render('terms');
    }

    /**
     * This action render the search page.
     * @return string
     */
    public function actionSearch()
    {
        return $this->render('search');
    }

    /**
     * This action render the markdown helper page.
     * @return string
     */
    public function actionMarkdown()
    {
        $post = Post::findOne(['id' => 450994]);

        return $this->render('markdown', ['post' => $post]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }

        $name = 'Ошибка';
        if ($code == 404) {
            $message = 'Страницы с таким адресом не существует.';
        } else {
            $message = 'Неверный запрос. Ссылка ошибочная или устарела.';
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('info', ['params' => [
                'name' => $name,
                'message' => $message,
            ]]);
        }
    }
}
