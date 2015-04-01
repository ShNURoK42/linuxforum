<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\Forum;
use app\models\Topic;

/**
 * Class ForumController
 */
class ForumController extends \app\components\BaseController
{
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        /** @var Forum $forum */
        $forum = Forum::findOne(['id' => $id]);

        $query = Topic::find()
            ->where(['forum_id' => $id])
            ->orderBy(['sticked' => SORT_DESC])
            ->addOrderBy(['last_post_created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('display_topics_count'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'forum' => $forum,
            'topics' => $topics,
        ]);
    }
}