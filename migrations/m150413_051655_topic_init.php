<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_051655_topic_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%topic}}', [
            'id' => Schema::TYPE_PK,
            'forum_id' => Schema::TYPE_SMALLINT . ' UNSIGNED NOT NULL',
            'subject' => Schema::TYPE_STRING . '(255) NOT NULL',
            'first_post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'first_post_user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'first_post_username' => Schema::TYPE_STRING . '(255) NOT NULL',
            'first_post_created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'last_post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'last_post_user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'last_post_username' => Schema::TYPE_STRING . '(255) NOT NULL',
            'last_post_created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'number_views' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'number_posts' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'closed' => Schema::TYPE_BOOLEAN . ' UNSIGNED NOT NULL DEFAULT 0',
            'sticked' => Schema::TYPE_BOOLEAN . ' UNSIGNED NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%topic}}');
    }
}
