<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_051705_user_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'role' => Schema::TYPE_STRING . '(64) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL',
            'password_change_token' => Schema::TYPE_STRING . '(32)',
            'password_changed_at' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'username' => Schema::TYPE_STRING . '(40) NOT NULL',
            'email' => Schema::TYPE_STRING . '(255) NOT NULL',
            'email_status' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'email_sent' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'about' => Schema::TYPE_TEXT,
            'timezone' => Schema::TYPE_STRING . '(255) NOT NULL',
            'last_posted_at' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'last_visited_at' => Schema::TYPE_INTEGER . ' UNSIGNED',
            'number_posts' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
