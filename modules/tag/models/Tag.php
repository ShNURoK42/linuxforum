<?php

namespace tag\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\db\ActiveQuery;
use topic\models\Topic;

/**
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $full_description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Topic[] $topics
 * @property integer $countTopics
 */
class Tag extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @return ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['id' => 'topic_id'])
            ->viaTable('tag_topic_assignment', ['tag_name' => 'name']);
    }

    /**
     * @return integer
     */
    public function getCountTopics()
    {
        $db = Instance::ensure('db', Connection::className());

        return (new Query)
            ->from('tag_topic_assignment')
            ->where([
                'tag_name' => $this->name,
            ])
            ->count('*', $db);
    }

    public static function getNamesList()
    {
        return \yii\helpers\ArrayHelper::getColumn(static::find()
            ->select('name')
            ->asArray()
            ->orderBy(['name' => SORT_ASC])
            ->all(), 'name');
    }

    /**
     * Convert array of strings to comma separated values
     * @param $tags array
     * @return string
     */
    public static function arrayToString($tags)
    {
        return implode(',', $tags);
    }
    /**
     * Convert string of comma separated values to array
     * @param $tags string
     * @return array
     */
    public static function stringToArray($tags)
    {
        return explode(',', $tags);
    }
}
