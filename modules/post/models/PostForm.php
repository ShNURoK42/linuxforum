<?php

namespace post\models;

use app\helpers\MarkdownParser;
use post\models\Post;
use topic\models\Topic;
use user\models\User;
use notify\models\UserMention;
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
            $post->message = $this->message;
            $post->save();
            $this->post = $post;

            $user->incrementPost();
            $user->last_posted_at = time();
            $user->save();

            $topic->incrementPost();
            $topic->last_post_username = $user->username;
            $topic->last_post_created_at = time();
            $topic->last_post_id = $post->id;
            $topic->last_post_user_id = $user->id;
            $topic->save();

            $forum = $topic->forum;
            $forum->number_posts += 1;
            $forum->last_post_created_at = time();
            $forum->last_post_user_id = $post->id;
            $forum->last_post_username = $user->username;
            $forum->save();

            // notification
            $mentions = MarkdownParser::findMentions($this->message);
            if (!empty($mentions)) {
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
                    $userMention->status = UserMention::MENTION_SATUS_UNVIEWED;
                    $userMention->save();
                }
            }

            return true;
        }

        return false;
    }
}