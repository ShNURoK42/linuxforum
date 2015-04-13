<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_163428_forum_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%forum}}', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'display_position' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'number_topics' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'number_posts' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'last_post_created_at' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'last_post_user_id' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'last_post_username' => Schema::TYPE_STRING . '(255)',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%forum}}');
    }
}
