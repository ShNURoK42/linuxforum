<?php

namespace notify\models;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use topic\models\Topic;
use user\models\User;

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
 * @property User $user
 * @property User $mentionUser
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMentionUser()
    {
        return $this->hasOne(User::className(), ['id' => 'mention_user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    public static function countByUser($id)
    {
        return static::find()
            ->where(['mention_user_id' => $id, 'status' => self::MENTION_SATUS_UNVIEWED])
            ->count();
    }
}
