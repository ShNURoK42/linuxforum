<?php

namespace topic\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use tag\models\Tag;
use topic\models\Topic;
use topic\models\CreateForm as CreateTopicForm;
use post\models\Post;
use post\models\CreateForm as CreatePostForm;
use notify\models\UserMention;


/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @param integer $id
     * @param integer $page
     * @return string
     */
    public function actionView($id, $page = 1)
    {
        /** @var Topic $topic */
        $topic = Topic::find()
            ->with('tags')
            ->where(['id' => $id])
            ->one();

        if (!$topic) {
            throw new NotFoundHttpException();
        }

        $topic->updateCounters(['number_views' => 1]);
        $topic->save();

        if (!Yii::$app->getUser()->getIsGuest()) {
            UserMention::markAsViewedByTopicID($id);
        }

        $dataProvider = Post::getDataProvider([
            'topic_id' => $topic->id,
            'page' => $page,
        ]);

        $model = new CreatePostForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($model->create($topic->id)) {
                $this->redirect('');
            }
        }

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
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
        $model = new CreateTopicForm();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->create()) {
            $this->redirect(['/topic/default/view', 'id' => $model->topic->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}