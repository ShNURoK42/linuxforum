<?php

namespace topic\models;

use Yii;
use yii\db\ActiveQuery;
use post\models\Post;
use tag\models\Tag;
use user\models\User;

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
 * @property Tag[] $tags
 * @property User $firstPostUser
 * @property User $lastPostUser
 * @property Post $firstPost
 * @property Post $lastPost
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

            $this->first_post_user_id = $user->id;
            $this->last_post_user_id = $user->id;
            $this->first_post_username = $user->username;
            $this->last_post_username = $user->username;
            $this->first_post_created_at = time();
            $this->last_post_created_at = time();
            $this->last_post_user_id = $user->id;
            $this->number_posts = 0;
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
     * Counts all topics.
     * @return integer
     */
    public static function countAll()
    {
        return static::find()->count();
    }

    /**
     * @return ActiveQuery
     */
    public function getFirstPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'first_post_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLastPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'last_post_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getFirstPostUser()
    {
        return $this->hasOne(User::className(), ['id' => 'first_post_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLastPostUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_post_user_id']);
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
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['name' => 'tag_name'])
            ->viaTable('tag_topic_assignment', ['topic_id' => 'id']);
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
}
