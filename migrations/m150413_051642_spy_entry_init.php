<?php

use yii\db\Schema;
use yii\db\Migration;

class m150413_051642_spy_entry_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%spy_entry}}', [
            'ip' => Schema::TYPE_BIGINT . ' NOT NULL',
            'form' => Schema::TYPE_STRING . '(255) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);

        $this->createIndex('ip', '{{%spy_entry}}', 'ip');
    }

    public function down()
    {
        $this->dropTable('{{%spy_entry}}');
    }
}
