<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055001_update_db extends Migration
{
    public function up()
    {
        // очистка БД
        $this->dropTable('ads');
        $this->dropTable('answers');
        $this->dropTable('bans');
        $this->dropTable('bbcodes');
        $this->dropTable('censoring');
        $this->dropTable('extensions');
        $this->dropTable('extension_hooks');
        $this->dropTable('fancy_alerts_posts');
        $this->dropTable('fancy_alerts_topics');
        $this->dropTable('fancy_stop_spam_identical_posts');
        $this->dropTable('fancy_stop_spam_logs');
        $this->dropTable('fancy_stop_spam_sfs_email_cache');
        $this->dropTable('fancy_stop_spam_sfs_ip_cache');
        $this->dropTable('fancy_user_activity');
        $this->dropTable('favorites');
        $this->dropTable('forum_subscriptions');
        $this->dropTable('groups');
        $this->dropTable('online');
        $this->dropTable('questions');
        $this->dropTable('ranks');
        $this->dropTable('reports');
        $this->dropTable('search_cache');
        $this->dropTable('search_matches');
        $this->dropTable('search_words');
        $this->dropTable('subscriptions');
        $this->dropTable('voting');
        $this->dropTable('reputation');
    }

    public function down()
    {
        echo "m141019_055001_update_db cannot be reverted.\n";

        return false;
    }
}
