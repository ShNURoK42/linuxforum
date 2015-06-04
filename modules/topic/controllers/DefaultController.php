<?php

namespace topic\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use tag\models\Tag;
use topic\models\Topic;
use post\models\Post;
use post\models\PostForm;
use topic\models\TopicForm;
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
            ->one();

        if (!$topic) {
            throw new NotFoundHttpException();
        }

        $topic->updateCounters(['number_views' => 1]);
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
     * @return string
     */
    public function actionList()
    {
        $name = Yii::$app->getRequest()->get('name');

        $tagModel = '';

        if (isset($name)) {
            /** @var Tag $tagModel */
            $tagModel = Tag::findOne(['name' => $name]);

            if (!$tagModel) {
                throw new NotFoundHttpException();
            }
        }

        $query = Topic::find()
            ->select('*')
            ->from('topic t')
            ->with('tags', 'firstPostUser', 'lastPostUser');
        if (isset($name)) {
            $query->innerJoin('tag_topic_assignment tta', 'tta.topic_id = t.id')
                ->where(['tta.tag_name' => $name]);
        }

        $sort_by = Yii::$app->getRequest()->get('sort_by');

        if (!$sort_by || $sort_by == 'new') {
            $query->orderBy(['t.last_post_created_at' => SORT_DESC]);
        } elseif ($sort_by == 'unanwser') {
            $query->andWhere(['t.number_posts' => 0])
                ->orderBy(['t.last_post_created_at' => SORT_DESC]);
        } elseif ($sort_by == 'own') {
            $id = Yii::$app->getUser()->getId();

            $query->andWhere(['t.first_post_user_id' => $id])
                ->orderBy(['t.last_post_created_at' => SORT_DESC]);
        }



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_topics_count'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'tagModel' => $tagModel,
            'topics' => $topics,
        ]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new TopicForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
            $this->redirect(['/topic/default/view', 'id' => $model->topic->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}