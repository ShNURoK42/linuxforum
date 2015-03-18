<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 *
 * @property string $id
 * @property string $cat_name
 * @property integer $disp_position
 *
 * @property Forum|ActiveRecord[] $forums
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forum::className(), ['cat_id' => 'id'])
            ->inverseOf('category');
    }
}
