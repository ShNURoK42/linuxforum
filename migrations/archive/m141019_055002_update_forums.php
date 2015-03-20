<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055002_update_forums extends Migration
{
    protected $table = '{{%category}}';

    public function up()
    {
        $this->renameTable('{{%forums}}', $this->table);

        $this->dropColumn($this->table, 'redirect_url');
        $this->dropColumn($this->table, 'moderators');
        $this->dropColumn($this->table, 'last_post');
        $this->dropColumn($this->table, 'last_poster');
        $this->dropColumn($this->table, 'sort_by');
        $this->dropColumn($this->table, 'parent_id');
        $this->dropColumn($this->table, 'last_post_id');
        $this->dropColumn($this->table, 'forum_desc');

        $this->renameColumn($this->table, 'forum_name', 'name');
        $this->renameColumn($this->table, 'disp_position', 'display_position');
        $this->renameColumn($this->table, 'cat_id', 'group_id');
        $this->renameColumn($this->table, 'num_topics', 'number_topics');
        $this->renameColumn($this->table, 'num_posts', 'number_posts');

        $this->alterColumn($this->table, 'name', Schema::TYPE_STRING . '(64) NOT NULL');
        $this->alterColumn($this->table, 'display_position', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'number_topics', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'number_posts', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');

        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY group_id INTEGER(11) UNSIGNED NOT NULL AFTER id');
    }

    public function down()
    {
        echo "m141019_055002_update_forums cannot be reverted.\n";

        return false;
    }
}
