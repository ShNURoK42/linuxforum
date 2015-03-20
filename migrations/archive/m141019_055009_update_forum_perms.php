<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055009_update_forum_perms extends Migration
{
    protected $table = '{{%auth_category}}';

    public function up()
    {
        $this->renameTable('{{%forum_perms}}', $this->table);

        $this->renameColumn($this->table, 'group_id', 'role_id');
        $this->renameColumn($this->table, 'forum_id', 'category_id');
        $this->renameColumn($this->table, 'read_forum', 'can_view');

        $this->dropColumn($this->table, 'post_replies');
        $this->dropColumn($this->table, 'post_topics');

        $this->addColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->addColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->alterColumn($this->table, 'role_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'category_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
    }

    public function down()
    {
        echo "m141019_055009_update_forum_perms cannot be reverted.\n";

        return false;
    }
}
