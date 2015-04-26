<?php

namespace post\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\helpers\MarkdownParser;
use post\models\Post;
use post\models\PostForm;

/**
 * Class PostController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionPreview()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $text = Yii::$app->getRequest()->post('message');
            if ($text == '') {
                return 'Пустое сообщение.';
            }

            $parsedown = new MarkdownParser();

            return $parsedown->parse($text);
        }

        throw new NotFoundHttpException();
    }

    /**
     * @return string
     */
    public function actionUpdate()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $text = Yii::$app->getRequest()->post('text');
            $id = substr(Yii::$app->getRequest()->post('id'), 1);

            /** @var Post $post */
            $post = Post::findOne(['id' => $id]);

            if (!$post || !Yii::$app->getUser()->can('updatePost', ['post' => $post])) {
                throw new NotFoundHttpException();
            }

            $model = new PostForm();
            $model->message = $text;
            if ($model->validate()) {
                $post->message = $text;
                $post->edited_at = time();
                $post->edited_by = Yii::$app->getUser()->getIdentity()->getId();
                $post->save();
            }

            return $post->displayMessage;
        }

        throw new NotFoundHttpException();
    }
}