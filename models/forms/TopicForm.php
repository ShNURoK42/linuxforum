<?php

namespace app\models\forms;

use Yii;
use app\helpers\MarkdownParser;
use app\models\Post;
use app\models\Topic;
use app\models\Forum;
use app\models\User;
use app\models\UserMention;

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

            // create post
            $post = new Post();
            $post->topic_id = 0;
            $post->message = $this->message;
            $post->save();

            // create topic
            $topic = new Topic();
            $topic->forum_id = $forum->id;
            $topic->subject = $this->subject;
            $topic->post = $post;
            $topic->save();

            // update post.topic_id
            $post->link('topic', $topic);
            $post->save();

            // update user.number_posts
            $user->incrementPost();
            $user->save();

            // update forum information
            $forum->number_topics += 1;
            $forum->last_post_created_at = time();
            $forum->last_post_user_id = $post->id;
            $forum->last_post_username = $user->username;
            $forum->save();

            $this->topic = $topic;

            // notification
            $mentions = MarkdownParser::findMentions($this->message);
            foreach ($mentions as $mention) {
                /** @var User $mentionUser */
                $mentionUser = User::findByUsername($mention);

                if (!$mentionUser) {
                    continue;
                }

                $userMention = new UserMention();
                $userMention->user_id = $user->id;
                $userMention->mention_user_id = $mentionUser->id;
                $userMention->post_id = $post->id;
                $userMention->topic_id = $topic->id;
                $userMention->save();
            }

            return true;
        }

        return false;
    }
}