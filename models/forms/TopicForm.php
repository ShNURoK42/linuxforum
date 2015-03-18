<?php

namespace app\models\forms;

use Yii;
use app\models\Post;
use app\models\Topic;
use app\models\Forum;

/**
 * Class TopicForm
 *
 * @property Topic $topic
 */
class TopicForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $message;

    /**
     * @var Forum
     */
    public $forum;
    /**
     * @var Forum
     */
    public $topic;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['subject', 'trim'],
            ['subject', 'required', 'message' => Yii::t('app/form', 'Required topic subject')],
            ['subject', 'string', 'min' => 6, 'tooShort' => Yii::t('app/form', 'String short topic subject')],
            ['subject', 'string', 'max' => 255, 'tooLong' => Yii::t('app/form', 'String long topic subject')],

            ['message', 'trim'],
            ['message', 'required', 'message' => Yii::t('app/form', 'Required message')],
            ['message', 'string', 'min' => 6, 'tooShort' => Yii::t('app/form', 'String short topic message')],
            ['message', 'string', 'max' => 65534, 'tooLong' => Yii::t('app/form', 'String long topic message')],
        ];
    }

    /**
     * @param Forum $forum
     * @return boolean
     */
    public function create($forum)
    {
        // very, so much, stupid source code :)
        if ($this->validate()) {
            $user = Yii::$app->getUser()->getIdentity();

            $post = new Post();
            $post->poster = $user->username;
            $post->poster_id = $user->id;
            $post->poster_ip = Yii::$app->getRequest()->getUserIP();
            $post->poster_email = $user->email;
            $post->message = $this->message;
            $post->posted = time();
            $post->topic_id = 0;
            $post->save();


            $topic = new Topic();
            $topic->poster = $user->username;
            $topic->subject = $this->subject;
            $topic->posted = time();
            $topic->first_post_id = $post->primaryKey;
            $topic->last_post = time();
            $topic->last_post_id = $post->primaryKey;
            $topic->last_poster = $user->username;
            $topic->num_views = 0;
            $topic->num_replies = 0;
            $topic->forum_id = $forum->id;
            $topic->save();

            $post->link('topic', $topic);
            $post->save();

            $user->num_posts += 1;
            $user->save();

            $forum->num_topics += 1;
            $forum->last_post = time();
            $forum->last_post_id = $post->id;
            $forum->last_poster = $user->username;
            $forum->save();

            $this->topic = $topic;

            return true;
        }

        return false;
    }
}