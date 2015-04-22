<?php

namespace forum\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * @property integer $id
 * @property string $name
 * @property integer $display_position
 *
 * @property Forum[] $forums
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forum::className(), ['category_id' => 'id'])
            ->inverseOf('category');
    }
}
