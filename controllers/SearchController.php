<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Topic;

class SearchController extends \yii\web\Controller
{
    public function actionViewActiveTopics()
    {
        // !!! need access check


        $time = time() - 86400;

        $query = Topic::find()
            ->where('last_post > :time', [':time' => $time])
            ->with('forum')
            ->addOrderBy(['last_post' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeLimit' => false,
                'defaultPageSize' => Yii::$app->config->get('o_disp_topics_default'),
            ],
        ]);

        $topics = $dataProvider->getModels();

        return $this->render('view_active_topics', [
            'dataProvider' => $dataProvider,
            'topics' => $topics,
        ]);
    }
}