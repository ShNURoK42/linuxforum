<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $mention_user_id
 * @property integer $post_id
 * @property integer $topic_id
 * @property boolean $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Topic $topic
 */
class UserMention extends \yii\db\ActiveRecord
{
    const MENTION_SATUS_UNVIEWED = 0;
    const MENTION_SATUS_VIEWED = 1;

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
        return 'user_mention';
    }

    /**
     * @return ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
