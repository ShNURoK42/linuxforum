<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "forum_perms".
 *
 * @property integer $group_id
 * @property integer $forum_id
 * @property integer $read_forum
 * @property integer $post_replies
 * @property integer $post_topics
 */
class ForumPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%forum_perms}}';
    }

    /**
     * Returns a value indicating whether a forum can be read.
     * @param integer $id forum identificator
     * @return boolean
     */
    public static function canRead($id)
    {
        $row = static::find()
            ->select('read_forum')
            ->where([
                'forum_id' => $id,
                'group_id' => Yii::$app->getUser()->getGroupID(),
            ])
            ->asArray()
            ->one();

        if ($row['read_forum'] == '0') {
            return false;
        }

        return true;
    }

    /**
     * Returns a value indicating whether a post can be create.
     * @param integer $id forum identificator
     * @return boolean
     */
    public static function canPostReply($id)
    {
        $row = static::find()
            ->select('post_replies')
            ->where([
                'forum_id' => $id,
                'group_id' => Yii::$app->getUser()->getGroupID(),
            ])
            ->asArray()
            ->one();

        if ($row['post_replies'] == '0') {
            return false;
        }

        return true;
    }

    /**
     * Returns a value indicating whether a topic can be create.
     * @param integer $id forum identificator
     * @return boolean
     */
    public static function canCreateTopic($id)
    {
        $row = static::find()
            ->select('post_topics')
            ->where([
                'forum_id' => $id,
                'group_id' => Yii::$app->getUser()->getGroupID(),
            ])
            ->asArray()
            ->one();

        if ($row['post_topics'] == '0') {
            return false;
        }

        return true;
    }

    /**
     * Returns the list of forums IDs which not readble of a specified user group.
     * @param integer $groupID
     * @return array
     */
    public static function fetchHiddenIDs($groupID)
    {
        $rows = (new Query)
            ->select('forum_id')
            ->from(static::tableName())
            ->where([
                'group_id' => $groupID,
                'read_forum' => 0
            ])
            ->all(static::getDb());

        return ArrayHelper::getColumn($rows, 'forum_id');
    }
}
