<?php

namespace editor\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use post\models\Post;
use user\models\User;

class DefaultController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionMention()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = Yii::$app->getRequest()->get('id');
            $query = Yii::$app->getRequest()->get('query');

            $usernames = [];
            if (is_numeric($id)) {
                $posts = Post::find()
                    ->with(['user' => function ($query) {
                        /** @var \yii\db\Query $query */
                        $query->andWhere(['NOT IN', 'id', Yii::$app->getUser()->getId()]);
                    }])
                    ->where(['topic_id' => $id])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->asArray()
                    ->all();
                $usernames = ArrayHelper::getColumn($posts, 'user');
                $usernames = array_unique(ArrayHelper::getColumn($usernames, 'username'));
                $usernames = array_filter($usernames);
            }
            if (!isset($id) || empty($usernames)){
                $usernames = User::find()
                    ->where(['like', 'username', $query . '%', false])
                    ->orderBy(['number_posts' => SORT_DESC])
                    ->limit(5)
                    ->asArray()
                    ->all();
                $usernames = ArrayHelper::getColumn($usernames, 'username');
            }
            $usernames = array_values($usernames);

            return $usernames;
        }

        throw new NotFoundHttpException();
    }
}