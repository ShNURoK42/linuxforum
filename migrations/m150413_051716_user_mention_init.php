<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_051716_user_mention_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_mention}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'mention_user_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'post_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'topic_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user_mention}}');
    }
}
