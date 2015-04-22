<?php

namespace topic\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use forum\models\Forum;
use post\models\Post;
use post\models\PostForm;
use topic\models\TopicForm;
use topic\models\Topic;
use notify\models\UserMention;


/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
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

        $topic->incrementView();
        $topic->save();

        $dataProvider = Post::getDataProviderByTopic($topic->id);
        $posts = $dataProvider->getModels();

        if (!Yii::$app->getUser()->getIsGuest()) {
            $userMentions = UserMention::findAll([
                'topic_id' => $id,
                'mention_user_id' => Yii::$app->getUser()->getId(),
                'status' => UserMention::MENTION_SATUS_UNVIEWED,
            ]);

            // user mention update
            foreach ($userMentions as $userMention) {
                $userMention->status = UserMention::MENTION_SATUS_VIEWED;
                $userMention->save();
            }

            $model = new PostForm();
            if ($model->load(Yii::$app->getRequest()->post()) && $model->create($topic)) {
                $this->redirect(['/topic/post/view', 'id' => $model->post->id, '#' => 'p' . $model->post->id]);
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

        if (!$forum || Yii::$app->getUser()->getIsGuest()) {
            throw new NotFoundHttpException();
        }

        $model = new TopicForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->create($forum)) {
            $this->redirect(['/topic/default/view', 'id' => $model->topic->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'forum' => $forum,
        ]);
    }
}