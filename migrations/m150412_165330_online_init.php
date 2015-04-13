<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_165330_online_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%online}}', [
            'id' => Schema::TYPE_PK,
            'user_ip' => Schema::TYPE_BIGINT . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . '  UNSIGNED NOT NULL',
            'vizited_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%online}}');
    }
}
