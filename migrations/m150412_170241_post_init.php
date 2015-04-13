<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_170241_post_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'user_ip' => Schema::TYPE_BIGINT . ' NOT NULL',
            'message' => Schema::TYPE_TEXT . ' NOT NULL',
            'topic_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'edited_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'edited_by' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
