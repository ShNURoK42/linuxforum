<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055003_update_config extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->dropTable('{{%config}}');

        $this->createTable('{{%config}}', [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'value' => Schema::TYPE_TEXT,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->insert('{{%config}}', ['name' => 'site_title', 'value' => 'linuxforum']);
        $this->insert('{{%config}}', ['name' => 'site_description', 'value' => 'сайт о linux']);
        $this->insert('{{%config}}', ['name' => 'email_support', 'value' => 'support@linuxforum.ru']);
        $this->insert('{{%config}}', ['name' => 'email_noreply', 'value' => 'no-reply@linuxforum.ru']);
    }

    public function down()
    {
        echo "m141019_055003_update_config cannot be reverted.\n";

        return false;
    }
}
