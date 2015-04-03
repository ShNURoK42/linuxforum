<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\Post;
use app\models\Topic;

class SearchController extends \app\components\BaseController
{
    public function actionViewActiveTopics()
    {
        // !!! need access check

        $time = time() - 86400;

        $query = Topic::find()
            ->where('last_post_created_at > :time AND forum_id NOT LIKE 0', [':time' => $time])
            ->with('forum')
            ->orderBy(['last_post_created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_topics_count'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('topic_list', [
            'title' => 'Активные темы',
            'dataProvider' => $dataProvider,
            'topics' => $topics,
        ]);
    }

    public function actionViewUnansweredTopics()
    {
        // !!! need access check

        $query = Topic::find()
            ->where('number_posts = 0 AND forum_id NOT LIKE 0')
            ->with('forum')
            ->orderBy(['last_post_created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_topics_count'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('topic_list', [
            'title' => 'Темы без ответов',
            'dataProvider' => $dataProvider,
            'topics' => $topics,
        ]);
    }

    public function actionViewOwnpostTopics()
    {
        // !!! need access check

        if (Yii::$app->getUser()->getIsGuest()) {
            throw new NotFoundHttpException();
        }

        $user = Yii::$app->getUser()->getIdentity();

        $posts = Post::find()
            ->select(['topic_id', 'user_id'])
            ->where('user_id = :user_id', [':user_id' => $user->id])
            ->asArray()
            ->all();

        $ids = ArrayHelper::getColumn($posts, 'topic_id');
        $uniqueIDs = array_unique($ids);

        $query = Topic::find()
            ->where(['IN', 'id', $uniqueIDs])
            ->andWhere('forum_id NOT LIKE 0')
            ->with('forum')
            ->orderBy(['last_post_created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_topics_count'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('topic_list', [
            'title' => 'Темы с вашим участием',
            'dataProvider' => $dataProvider,
            'topics' => $topics,
        ]);
    }
}