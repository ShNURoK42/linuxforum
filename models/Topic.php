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
 * @property Forum $forum
 */
class Topic extends \yii\db\ActiveRecord
{
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
