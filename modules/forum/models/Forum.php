<?php

namespace forum\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "forums".
 *
 * @property integer $id
 * @property string $name
 * @property integer $number_topics
 * @property integer $number_posts
 * @property integer $last_post_created_at
 * @property integer $last_post_user_id
 * @property string $last_post_username
 * @property integer $display_position
 * @property integer $category_id
 * @property integer $parent_id
 *
 * @property Category $category
 */
class Forum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
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
