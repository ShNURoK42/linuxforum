<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $mention_user_id
 * @property integer $post_id
 * @property integer $topic_id
 * @property boolean $viewed
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserMention extends \yii\db\ActiveRecord
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
        return 'user_mention';
    }
}
