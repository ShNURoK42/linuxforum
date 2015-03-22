<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $forum_id
 * @property string $subject
 * @property integer $first_post_id
 * @property integer $first_post_user_id
 * @property string $first_post_username
 * @property integer $first_post_created_at
 * @property integer $last_post_id
 * @property integer $last_post_user_id
 * @property string $last_post_username
 * @property integer $last_post_created_at
 * @property integer $number_views
 * @property integer $number_posts
 * @property integer $closed
 * @property integer $sticked
 *
 * @property Post[] $posts
 * @property Post $post
 * @property Forum $forum
 */
class Topic extends \yii\db\ActiveRecord
{
    /** @var Post */
    private $_post;
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $user = Yii::$app->getUser()->getIdentity();

            $this->first_post_created_at = time();
            $this->first_post_username = $user->username;
            $this->first_post_user_id = $user->id;
            $this->last_post_created_at = time();
            $this->last_post_username = $user->username;
            $this->last_post_user_id = $user->id;
            $this->number_posts = 1;
            $this->number_views = 0;
            $this->first_post_id = $this->_post->id;
            $this->last_post_id = $this->_post->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%topic}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::className(), ['id' => 'forum_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id'])
            ->inverseOf('topic');
    }

    /**
     * @param Post $post
     * @return self
     */
    public function setPost($post)
    {
        $this->_post = $post;

        return $this;
    }

    public function incrementView()
    {
        $this->number_views = $this->number_views + 1;
    }

    public function decrementView()
    {
        $this->number_views = $this->number_views - 1;
    }

    public function incrementPost()
    {
        $this->number_posts = $this->number_posts + 1;
    }

    public function decrementPost()
    {
        $this->number_posts = $this->number_posts - 1;
    }
}
