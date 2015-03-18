<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\helpers\AccessHelper;
use app\models\Forum;
use app\models\Topic;

/**
 * Class ForumController
 */
class ForumController extends \yii\web\Controller
{
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $forum = Forum::find()
            ->where(['id' => $id])
            ->one();

        if (!$forum || !AccessHelper::canReadForum($forum)) {
            throw new NotFoundHttpException();
        }

        $query = Topic::find()
            ->where(['forum_id' => $id])
            ->orderBy(['sticky' => SORT_DESC])
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

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'forum' => $forum,
            'topics' => $topics,
        ]);
    }
}