<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "groups".
 *
 * @property string $g_id
 * @property string $g_title
 * @property string $g_user_title
 * @property integer $g_moderator
 * @property integer $g_mod_edit_users
 * @property integer $g_mod_rename_users
 * @property integer $g_mod_change_passwords
 * @property integer $g_mod_ban_users
 * @property integer $g_read_board
 * @property integer $g_view_users
 * @property integer $g_post_replies
 * @property integer $g_post_topics
 * @property integer $g_edit_posts
 * @property integer $g_delete_posts
 * @property integer $g_delete_topics
 * @property integer $g_set_title
 * @property integer $g_search
 * @property integer $g_search_users
 * @property integer $g_send_email
 * @property integer $g_post_flood
 * @property integer $g_search_flood
 * @property integer $g_email_flood
 * @property integer $g_rep_minus_min
 * @property integer $g_rep_plus_min
 * @property integer $g_rep_enable
 * @property integer $g_poll_add
 * @property string $link_color
 * @property string $hover_color
 * @property integer $g_fp_enable
 * @property integer $gl_position
 * @property integer $gl_visible
 * @property integer $g_mug_count
 * @property integer $g_mug_enable
 */
class Group extends ActiveRecord
{
    const GROUP_UNVERIFIED = 0;
    const GROUP_ADMIN = 1;
    const GROUP_GUEST = 2;
    const GROUP_USER = 3;
    const GROUP_MODERATOR = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%groups}}';
    }

    /**
     * @return array
     */
    public static function getDropDownItems()
    {
        $rows = static::find()
            ->select(['g_id', 'g_title'])
            ->where(['NOT IN', 'g_id', self::GROUP_GUEST])
            ->asArray()
            ->all();

        $result = ArrayHelper::map($rows, 'g_id', 'g_title');

        return $result;
    }
}
