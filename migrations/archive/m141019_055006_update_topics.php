<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055006_update_topics extends Migration
{
    protected $table = '{{%question}}';

    public function up()
    {
        $this->renameTable('{{%topics}}', $this->table);

        $this->dropColumn($this->table, 'post_show_first_post');
        $this->dropColumn($this->table, 'moved_to');
        $this->dropColumn($this->table, 'agreed');
        $this->dropColumn($this->table, 'sticky');
        $this->dropColumn($this->table, 'first_post_id');
        $this->dropColumn($this->table, 'last_post');
        $this->dropColumn($this->table, 'last_post_id');
        $this->dropColumn($this->table, 'last_poster');
        $this->dropColumn($this->table, 'closed');

        $this->renameColumn($this->table, 'poster', 'user_id');
        $this->renameColumn($this->table, 'posted', 'created_at');
        $this->renameColumn($this->table, 'num_views', 'number_views');
        $this->renameColumn($this->table, 'num_replies', 'number_posts');
        $this->renameColumn($this->table, 'forum_id', 'category_id');

        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'number_views', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'number_posts', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');

        $this->addColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY updated_at INTEGER(11) UNSIGNED NOT NULL AFTER created_at');

        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY category_id INTEGER(11) UNSIGNED NOT NULL AFTER id');
    }

    public function down()
    {
        echo "m141019_055006_update_topics cannot be reverted.\n";

        return false;
    }
}
