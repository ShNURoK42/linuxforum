<?php

namespace app\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Forum;
use app\models\Group;
use app\models\Topic;
use app\models\ForumPermission;

/**
 * Class AccessHelper
 */
class AccessHelper
{
    /**
     * @param Forum $forum
     * @return boolean
     */
    public static function canReadForum($forum)
    {
        return ForumPermission::canRead($forum->id);
    }

    /**
     * @param Forum $forum
     * @return boolean
     */
    public static function canCreateTopic($forum)
    {
        return (ForumPermission::canCreateTopic($forum->id) && static::can('post_topics')) ;
    }

    /**
     * @param $topic Topic
     * @return boolean
     */
    public static function canPostReplyInTopic(Topic $topic)
    {
        if ($topic->closed) {
            return false;
        }

        return (ForumPermission::canPostReply($topic->id) && static::can('post_replies'));
    }

    /**
     * Check access for the permission.
     * If `$groupID = null` that means current user group identificator.
     * @param $permission
     * @param $group group identificator
     * @return boolean
     */
    public static function can($permission, $group = null)
    {
        if (!isset($group)) {
            $group = Yii::$app->getUser()->getGroupID();
        }

        $data = Yii::$app->cache->get('group');

        if ($data === false) {
            $array = Group::find()
                ->select([
                    'g_id',
                    'g_moderator',
                    'g_mod_edit_users',
                    'g_mod_rename_users',
                    'g_mod_change_passwords',
                    'g_mod_ban_users',
                    'g_read_board',
                    'g_view_users',
                    'g_post_replies',
                    'g_post_topics',
                    'g_edit_posts',
                    'g_delete_posts',
                    'g_delete_topics',
                    'g_set_title',
                    'g_search',
                    'g_search_users',
                    'g_send_email',
                    'g_post_flood',
                    'g_search_flood',
                    'g_email_flood'
                ])
                ->asArray()
                ->all();

            $data = ArrayHelper::index($array, 'g_id');
            Yii::$app->cache->set('group', $data);
        }


        // fix prefix 'g_' in colomn names.
        $permission = 'g_' . $permission;
        if (!empty($data[$group][$permission])) {
            $value = $data[$group][$permission];

            if ($value == 1) {
                return true;
            }
        }

        return false;
    }
}