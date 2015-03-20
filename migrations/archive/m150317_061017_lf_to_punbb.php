<?php

use yii\db\Schema;
use yii\db\Migration;

class m150317_061017_lf_to_punbb extends Migration
{
    public function up()
    {
        // delete tables
        $this->dropTable('ads');
        $this->dropTable('answers');
        $this->dropTable('bbcodes');
        $this->dropTable('fancy_alerts_posts');
        $this->dropTable('fancy_alerts_topics');
        $this->dropTable('fancy_stop_spam_identical_posts');
        $this->dropTable('fancy_stop_spam_logs');
        $this->dropTable('fancy_stop_spam_sfs_email_cache');
        $this->dropTable('fancy_stop_spam_sfs_ip_cache');
        $this->dropTable('fancy_user_activity');
        $this->dropTable('favorites');
        $this->dropTable('questions');
        $this->dropTable('reputation');
        $this->dropTable('voting');

        // users table
        $this->dropColumn('{{%users}}', 'pun_pm_new_messages');
        $this->dropColumn('{{%users}}', 'pun_pm_long_subject');
        $this->dropColumn('{{%users}}', 'pun_bbcode_enabled');
        $this->dropColumn('{{%users}}', 'pun_bbcode_use_buttons');
        $this->dropColumn('{{%users}}', 'rep_enable');
        $this->dropColumn('{{%users}}', 'rep_disable_adm');
        $this->dropColumn('{{%users}}', 'rep_minus');
        $this->dropColumn('{{%users}}', 'rep_plus');
        $this->dropColumn('{{%users}}', 'distr');
        $this->dropColumn('{{%users}}', 'show_subforums_list');
        $this->dropColumn('{{%users}}', 'loginza_identity');
        $this->dropColumn('{{%users}}', 'loginza_uid');
        $this->dropColumn('{{%users}}', 'loginza_provider');
        $this->dropColumn('{{%users}}', 'stick_favorites');
        $this->dropColumn('{{%users}}', 'fancy_stop_spam_bot');
        $this->dropColumn('{{%users}}', 'enable_pm_email');
        $this->dropColumn('{{%users}}', 'birthday');
        $this->dropColumn('{{%users}}', 'bday_email');

        // topics table
        $this->dropColumn('{{%topics}}', 'agreed');
        $this->dropColumn('{{%topics}}', 'post_show_first_post');

        // forums table
        $this->dropColumn('{{%forums}}', 'parent_id');

        // groups table
        $this->dropColumn('{{%groups}}', 'g_rep_minus_min');
        $this->dropColumn('{{%groups}}', 'g_rep_plus_min');
        $this->dropColumn('{{%groups}}', 'g_rep_enable');
        $this->dropColumn('{{%groups}}', 'g_poll_add');
        $this->dropColumn('{{%groups}}', 'link_color');
        $this->dropColumn('{{%groups}}', 'hover_color');
        $this->dropColumn('{{%groups}}', 'g_fp_enable');
        $this->dropColumn('{{%groups}}', 'gl_position');
        $this->dropColumn('{{%groups}}', 'gl_visible');
        $this->dropColumn('{{%groups}}', 'g_mug_count');
        $this->dropColumn('{{%groups}}', 'g_mug_enable');
        $this->dropColumn('{{%groups}}', 'g_merge_posts');
    }
}
