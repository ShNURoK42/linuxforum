<?php

namespace user\models;

use Yii;

/**
 * @property integer $user_ip
 * @property integer $user_id
 * @property integer $vizited_at
 */
class UserOnline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_online}}';
    }

    public static function deleteInactiveUsers($duration = 900)
    {
        $time = time() - $duration;

        return static::deleteAll(['<', 'vizited_at', $time]);
    }

    public static function countGuests()
    {
        return static::find()
            ->where('user_id = 0')
            ->count();
    }

    public static function countUsers()
    {
        return static::find()
            ->where('user_id > 0')
            ->count();
    }

    public static function getActiveUsers()
    {
        $array_ids = static::find()
            ->select(['user_id'])
            ->where('user_id > 0')
            ->asArray()
            ->all();

        $ids = \yii\helpers\ArrayHelper::getColumn($array_ids, 'user_id');

        $users = User::find()
            ->select(['id', 'username'])
            ->where(['IN', 'id', $ids])
            ->asArray()
            ->all();

        return $users;
    }
}
