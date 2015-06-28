<?php

namespace post\models;

use Yii;
use topic\models\Topic;

/**
 * Class CreateForm
 *
 * @property $post Post
 * @property $topic Topic
 */
class CreateForm extends \yii\base\Model
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
     * @var Topic
     */
    private $_topic;

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
     * Create post
     * @param integer $id
     * @return boolean
     */
    public function create($id)
    {
        $user = Yii::$app->getUser()->getIdentity();
        $topic = Topic::findOne($id);
        $this->_topic = $topic;

        $post = new Post();
        $post->topic_id = $this->_topic->id;
        $post->message = $this->message;
        $post->save();

        $this->_topic->updateCounters(['number_posts' => 1]);
        $this->_topic->last_post_id = $post->id;
        $this->_topic->last_post_user_id = $user->id;
        $this->_topic->last_post_created_at = time();
        $this->_topic->last_post_username = $user->username;

        $this->_post = $post;

        if ($this->_topic->save()) {
            return true;
        }
        return false;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->_post;
    }

    /**
     * @return Topic
     */
    public function getTopic()
    {
        return $this->_topic;
    }
}