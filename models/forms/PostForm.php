<?php

namespace app\models\forms;

use app\models\Post;
use app\models\Topic;
use Yii;

/**
 * Class TopicForm
 */
class PostForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $message;
    public $post;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['message', 'trim'],
            ['message', 'required', 'message' => Yii::t('app/form', 'Required message')],
            ['message', 'string', 'min' => 6, 'tooShort' => Yii::t('app/form', 'String short topic message')],
            ['message', 'string', 'max' => 65534, 'tooLong' => Yii::t('app/form', 'String long topic message')],
        ];
    }

    /**
     * @param Topic $topic
     * @return boolean
     */
    public function create($topic)
    {
        if ($this->validate()) {
            $user = Yii::$app->getUser()->getIdentity();

            $post = new Post();
            $post->topic_id = $topic->id;
            $post->user_id = $user->id;
            $post->user_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $post->message = $this->message;
            $post->created_at = time();
            $post->save();
            $this->post = $post;

            $user->incrementPost();
            $user->save();

            $topic->incrementPost();
            $topic->last_post_username = $user->username;
            $topic->last_post_created_at = time();
            $topic->last_post_id = $post->id;
            $topic->last_post_user_id = $user->id;
            $topic->save();

            $forum = $topic->forum;
            $forum->num_posts += 1;
            $forum->last_post = time();
            $forum->last_post_id = $post->id;
            $forum->last_poster = $user->username;
            $forum->save();

            return true;
        }

        return false;
    }
}