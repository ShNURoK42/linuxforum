<?php

use yii\db\Schema;
use yii\db\Migration;

class m141020_055001_create_log_entry extends Migration
{
    public function up()
    {
        $table = 'log_entry';

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($table, [
            'created_at' => Schema::TYPE_INTEGER,
            'ip' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'form_name' => Schema::TYPE_STRING,
        ], $tableOptions);
    }

    public function down()
    {
        echo "m141020_055001_create_log_entry cannot be reverted.\n";

        return false;
    }
}
