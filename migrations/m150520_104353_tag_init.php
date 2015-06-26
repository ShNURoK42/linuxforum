<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_104353_tag_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tag}}', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'short_description' => Schema::TYPE_STRING . '(255) NOT NULL',
            'full_description' => Schema::TYPE_TEXT,
            'frequency' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->insert('{{%tag}}', [
            'name' => 'default',
            'short_description' => 'Default tag',
            'full_description' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        echo "m150520_104353_tag_init cannot be reverted.\n";

        return false;
    }
}
