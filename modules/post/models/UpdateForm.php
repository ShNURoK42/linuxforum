<?php

namespace post\models;

use Yii;
use post\models\Post;

/**
 * Class PostForm
 *
 * @property $post Post
 */
class UpdateForm extends \yii\base\Model
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
     * @param integer $id
     * @return boolean
     */
    public function update($id)
    {
        /** @var Post $post */
        $post = Post::findOne(['id' => $id]);
        if (!$post && !Yii::$app->getUser()->can('updatePost', ['post' => $post])) {
            return false;
        }
        $post->message = $this->message;
        $post->edited_at = time();
        $post->edited_by = Yii::$app->getUser()->getIdentity()->getId();
        if ($post->save()) {
            $this->_post = $post;
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
}