<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_122743_tag_topic_assignment_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tag_topic_assignment}}', [
            'tag_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'topic_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'PRIMARY KEY (tag_name, topic_id)',
        ], $tableOptions);

        $this->createIndex('idx-topic_id', '{{%tag_topic_assignment}}', 'topic_id');
    }

    public function down()
    {
        echo "m150520_122743_tag_topic_assignment_init cannot be reverted.\n";

        return false;
    }
}
