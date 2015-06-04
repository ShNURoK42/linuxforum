<?php

namespace topic\models;

use Yii;
use app\helpers\MarkdownParser;
use post\models\Post;
use user\models\User;
use notify\models\UserMention;
use tag\models\Tag;

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
     * @var string
     */
    public $tags;
    /**
     * @var Topic
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

            ['tags', 'required', 'message' => Yii::t('app/form', 'Required tags')],
            ['tags', 'tagsValidation'],

        ];
    }

    /**
     * Validate tags attribute.
     * @param string $attribute tags attribute.
     */
    public function tagsValidation($attribute)
    {
        $tags = explode(',', $this->tags);

        $tagDownLimit = 1;
        $tagUpLimit = 5;
        if (sizeof($tags) < $tagDownLimit) {
            $this->addError($attribute, 'Количество тегов должно быть не меньше ' . $tagDownLimit);
        }

        if (sizeof($tags) > $tagUpLimit) {
            $this->addError($attribute, 'Количество тегов не должно быть больше ' . $tagUpLimit);
        }

        foreach ($tags as $tag) {
            $tag = trim($tag);

            if (!preg_match('/^[\w-]+$/', $tag, $matches) || strlen($matches[0]) < 2 || strlen($matches[0]) > 64) {
                $this->addError($attribute, 'Неверно указан тег: ' . $tag);
                return;
            }
        }
    }

    /**
     * @return boolean
     */
    public function create()
    {
        // very, so much, stupid source code :)
        if ($this->validate()) {
            $user = Yii::$app->getUser()->getIdentity();

            // create post
            $post = new Post();
            $post->topic_id = 0;
            $post->message = $this->message;
            $post->save();

            if ($post->save()) {
                // create topic
                $topic = new Topic();
                $topic->subject = $this->subject;
                $topic->post = $post;
                $topic->save();

                // update post.topic_id
                $post->link('topic', $topic);

                $tagNames = explode(',', $this->tags);
                foreach ($tagNames as $tagName) {
                    /** @var Tag $tagModel */
                    $tagModel = Tag::findOne($tagName);
                    $topic->link('tags', $tagModel);
                }

                $this->topic = $topic;

                return true;
            }
        }

        return false;
    }
}