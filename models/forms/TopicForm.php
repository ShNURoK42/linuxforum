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
            $post->topic_id = 0;
            $post->user_id = $user->id;
            $post->user_ip = ip2long(Yii::$app->getRequest()->getUserIP());
            $post->message = $this->message;
            $post->created_at = time();
            $post->save();

            $topic = new Topic();
            $topic->forum_id = $forum->id;
            $topic->subject = $this->subject;
            $topic->first_post_username = $user->username;
            $topic->first_post_created_at = time();
            $topic->first_post_id = $post->id;
            $topic->first_post_user_id = $user->id;
            $topic->last_post_username = $user->username;
            $topic->last_post_created_at = time();
            $topic->last_post_id = $post->id;
            $topic->last_post_user_id = $user->id;
            $topic->number_posts = 1;
            $topic->number_views = 0;
            $topic->save();

            $post->link('topic', $topic);
            $post->save();

            $user->incrementPost();
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