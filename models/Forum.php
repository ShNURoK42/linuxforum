<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "forums".
 *
 * @property string $id
 * @property string $forum_name
 * @property string $forum_desc
 * @property string $redirect_url
 * @property string $moderators
 * @property string $num_topics
 * @property string $num_posts
 * @property string $last_post
 * @property string $last_post_id
 * @property string $last_poster
 * @property integer $sort_by
 * @property integer $disp_position
 * @property string $cat_id
 * @property string $parent_id
 *
 * @property Category|ActiveRecord $category
 */
class Forum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forums}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['forum_id' => 'id'])
            ->inverseOf('forum');
    }
}
