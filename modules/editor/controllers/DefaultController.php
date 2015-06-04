<?php

namespace editor\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use post\models\Post;
use user\models\User;
use yii\web\NotFoundHttpException;

class DefaultController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionMention()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = substr(Yii::$app->getRequest()->get('id'), 1);
            $query = Yii::$app->getRequest()->get('query');

            if (is_numeric($id)) {
                $posts = Post::find()
                    ->with([
                        'user' => function ($query) {
                            /** @var \yii\db\Query $query */
                            $query->andWhere(['not in', 'id', Yii::$app->getUser()->getId()]);
                        },
                    ])
                    ->where(['topic_id' => $id])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->asArray()
                    ->all();

                $users = ArrayHelper::getColumn($posts, 'user');
                $usernames = array_unique(ArrayHelper::getColumn($users, 'username'));
                $usernames = array_diff($usernames, ['']);
            } else {
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