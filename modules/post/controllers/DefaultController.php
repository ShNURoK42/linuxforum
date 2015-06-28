<?php

namespace post\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use common\helpers\MarkdownParser;
use topic\models\Topic;
use post\models\Post;
use post\models\UpdateForm;
use post\models\CreateForm;

/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @param integer $id post identificator.
     * @return string
     */
    public function actionView($id)
    {
        /** @var Post $post */
        $post = Post::findOne(['id' => $id]);

        if (!$post) {
            throw new NotFoundHttpException();
        }

        return $this->run('/topic/default/view', [
            'id' => $post->topic_id,
            'page' => $this->getPageByPost($post),
        ]);
    }

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

        throw new BadRequestHttpException();
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model = new CreateForm();
            if ($model->load(Yii::$app->getRequest()->post(), '')) {
                if ($model->validate()) {
                    $id = Yii::$app->getRequest()->post('topic_id');
                    if ($model->create($id)) {
                        $count = Post::find()
                            ->where(['topic_id' => $model->getTopic()->id])
                            ->count();

                        $data['post'] = \post\widgets\Post::widget([
                            'post' => $model->getPost(),
                            'count' => $count,
                        ]);
                        $data['post_id'] = $model->getPost()->getPrimaryKey();
                        $data['page'] = $this->getPageByPost($model->getPost());

                        return $data;
                    }
                } else {
                    return ['errors' => $model->getFirstErrors()];
                }
            }
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

            $model = new UpdateForm();
            if ($model->load(Yii::$app->getRequest()->post(), '')) {
                if ($model->validate()) {
                    $id = Yii::$app->getRequest()->post('post_id');
                    if ($model->update($id)) {
                        return $model->getPost()->displayMessage;
                    }
                } else {
                    return ['errors' => $model->getFirstErrors()];
                }
            }
        }
        throw new NotFoundHttpException();
    }

    /**
     * Returns page number in topic by post.
     * @param Post $post post model.
     * @return integer
     */
    protected function getPageByPost($post)
    {
        $rows = Post::find()
            ->select('id')
            ->where(['topic_id' => $post->topic_id])
            ->asArray()
            ->all();

        $index = 1;
        foreach ($rows as $row) {
            if ($row['id'] == $post->id) {
                break;
            }
            $index++;
        }

        $page = ceil($index / Yii::$app->config->get('display_posts_count'));

        return $page;
    }
}