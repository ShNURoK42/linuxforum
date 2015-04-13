<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_162810_config_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%config}}', [
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'value' => Schema::TYPE_TEXT,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->insert('{{%config}}', ['name' => 'site_title', 'value' => 'Site name']);
        $this->insert('{{%config}}', ['name' => 'support_email', 'value' => 'support@domain.com']);
        $this->insert('{{%config}}', ['name' => 'display_topics_count', 'value' => 30]);
        $this->insert('{{%config}}', ['name' => 'display_posts_count', 'value' => 30]);
    }

    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
