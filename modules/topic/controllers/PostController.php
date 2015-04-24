<?php

namespace topic\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use post\models\Post;
use post\models\PostForm;
use topic\models\Topic;
use notify\models\UserMention;


/**
 * Class PostController
 */
class PostController extends \yii\web\Controller
{
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        /** @var Post $post */
        $post = Post::findOne(['id' => $id]);

        /** @var Topic $topic */
        $topic = Topic::find()
            ->where(['id' => $post->topic_id])
            ->with('forum')
            ->one();

        if (!$topic) {
            throw new NotFoundHttpException();
        }

        $topic->updateCounters(['number_views' => 1]);
        $topic->save();

        if (!Yii::$app->getUser()->getIsGuest()) {
            $userMentions = UserMention::findAll([
                'post_id' => $id,
                'mention_user_id' => Yii::$app->getUser()->getId(),
                'status' => UserMention::MENTION_SATUS_UNVIEWED,
            ]);

            foreach ($userMentions as $userMention) {
                $userMention->status = UserMention::MENTION_SATUS_VIEWED;
                $userMention->save();
            }
        }

        $dataProvider = Post::getDataProviderByTopic($topic->id);
        $dataProvider->pagination->route = '/topic/default/view';
        $dataProvider->pagination->params = [
            'id' => $topic->id,
            'page' => $this->getPostPage($post),
        ];

        $posts = $dataProvider->getModels();

        $model = new PostForm();

        return $this->render('/default/view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }

    /**
     * Returns page number in topic by post.
     * @param Post $post post model.
     * @return integer
     */
    protected function getPostPage($post)
    {
        $rows = Post::find()
            ->select('id')
            ->where(['topic_id' => $post->topic_id])
            ->asArray()
            ->all();

        $index = 1;
        foreach ($rows as $row) {
            if ($row['id'] == $post->id) {
                break;
            }
            $index++;
        }

        $page = ceil($index / Yii::$app->config->get('display_posts_count'));

        return $page;
    }
}