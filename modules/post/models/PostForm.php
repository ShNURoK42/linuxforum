<?php

namespace post\models;

use Yii;
use topic\models\Topic;

/**
 * Class PostForm
 *
 * @property Post $post
 */
class PostForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var Post
     */
    private $_post;

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

            $this->getPost()->topic_id = $topic->id;
            $this->getPost()->message = $this->message;
            $this->getPost()->save();

            $topic->updateCounters(['number_posts' => 1]);
            $topic->last_post_username = $user->username;
            $topic->last_post_created_at = time();
            $topic->last_post_id = $this->getPost()->id;
            $topic->last_post_user_id = $user->id;
            $topic->save();

            $forum = $topic->forum;
            $forum->updateCounters(['number_posts' => 1]);
            $forum->last_post_created_at = time();
            $forum->last_post_user_id = $this->getPost()->id;
            $forum->last_post_username = $user->username;
            $forum->save();

            return true;
        }

        return false;
    }

    public function getPost()
    {
        if (!$this->_post instanceof Post) {
            $this->_post = new Post();
        }

        return $this->_post;
    }
}