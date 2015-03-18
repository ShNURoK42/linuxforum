<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "topics".
 *
 * @property string $id
 * @property string $poster
 * @property string $subject
 * @property string $posted
 * @property string $first_post_id
 * @property string $last_post
 * @property string $last_post_id
 * @property string $last_poster
 * @property string $num_views
 * @property string $num_replies
 * @property integer $closed
 * @property integer $sticky
 * @property integer $agreed
 * @property string $moved_to
 * @property string $forum_id
 *
 * @property Post[] $posts
 * @property Forum $forum
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @var Forum
     */
    private $_forum;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%topics}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::className(), ['id' => 'forum_id']);
    }

    /**
     * @param Forum $forum
     * @return self
     */
    public function setForum($forum)
    {
        $this->_forum = $forum;

        return $this;
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id'])
            ->inverseOf('topic');
    }
}
