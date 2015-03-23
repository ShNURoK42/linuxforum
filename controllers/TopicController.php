<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\helpers\AccessHelper;
use app\models\Forum;
use app\models\Post;
use app\models\Topic;
use app\models\forms\PostForm;
use app\models\forms\TopicForm;

/**
 * Class TopicController
 */
class TopicController extends \app\components\BaseController
{
    /**
     * @param $id topic identificator.
     * @return string
     */
    public function actionView($id)
    {
        /** @var Topic $topic */
        $topic = Topic::find()
            ->where(['id' => $id])
            ->with('forum')
            ->one();

        if (!$topic || !AccessHelper::canReadForum($topic->forum)) {
            throw new NotFoundHttpException();
        }

        $topic->incrementView();
        $topic->save();

        $dataProvider = Post::getDataProviderByTopic($topic->id);
        $posts = $dataProvider->getModels();

        if (AccessHelper::canPostReplyInTopic($topic)) {
            $model = new PostForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->create($topic)) {
                $this->redirect(['post/view', 'id' => $model->post->id, '#' => 'p' . $model->post->id]);
            }

            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'topic' => $topic,
                'posts' => $posts,
            ]);
        } else {
            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'topic' => $topic,
                'posts' => $posts,
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCreate($id)
    {
        /** @var Forum $forum */
        $forum = Forum::find()
            ->where(['id' => $id])
            ->one();

        if (!$forum || !AccessHelper::canCreateTopic($forum)) {
            throw new NotFoundHttpException();
        }

        $model = new TopicForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->create($forum)) {
            $this->redirect(['topic/view', 'id' => $model->topic->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'forum' => $forum,
        ]);
    }
}