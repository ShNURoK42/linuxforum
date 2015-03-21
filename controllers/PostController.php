<?php

namespace app\controllers;

use app\models\forms\PostForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use app\helpers\AccessHelper;
use app\models\Post;
use app\models\Topic;

/**
 * Class PostController
 */
class PostController extends \yii\web\Controller
{
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        /** @var Post $post */
        $post = Post::findOne(['id' => $id]);

        /** @var Topic $topic */
        $topic = Topic::find()
            ->where(['id' => $post->topic_id])
            ->with('forum')
            ->one();

        if (!$topic || !AccessHelper::canReadForum($topic->forum)) {
            throw new NotFoundHttpException();
        }

        $query = Post::find()
            ->where(['topic_id' => $post->topic_id])
            ->with('user', 'user.group')
            ->orderBy(['created_at' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'route' => 'topic/view',
                'params' => [
                    'id' => $topic->id,
                    'page' => $this->getPostPage($post),
                ],
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('o_disp_posts_default'),
            ],
        ]);

        $posts = $dataProvider->getModels();

        $model = new PostForm();

        return $this->render('/topic/view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }

    /**
     * @return string
     */
    public function actionPreview()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $text = Yii::$app->getRequest()->post('text');
            if ($text == '') {
                return 'Пустое сообщение';
            }

            $parsedown = new \app\helpers\MarkdownParser();
            $text = $parsedown->text($_POST['text']);

            return $text;
        }

        throw new NotFoundHttpException();
    }

    /**
     * @param $id topic identificator
     * @return string
     */
    public function actionCreate($id)
    {
        /** @var Topic $topic */
        $topic = Topic::find()
            ->where(['id' => $id])
            ->one();

        if (!$topic || !AccessHelper::canPostReplyInTopic($topic)) {
            throw new NotFoundHttpException();
        }

        $model = new PostForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
            $this->redirect(['topic/view', 'id' => $model->topic->id]);
        }
    }

    /**
     * Return page number in topic by post.
     * @param Post $post post model.
     * @return integer
     */
    protected function getPostPage($post)
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

        $page = ceil($index / Yii::$app->config->get('o_disp_posts_default'));

        return $page;
    }
}