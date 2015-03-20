<?php

use yii\db\Schema;
use yii\db\Migration;

class m150320_104201_fix_topic extends Migration
{
    protected $table = '{{%topic}}';

    public function up()
    {
        $this->renameTable('{{%topics}}', $this->table);
        $this->execute('ALTER TABLE topic ENGINE = InnoDB;');

        $this->dropColumn($this->table, 'moved_to');

        $this->renameColumn($this->table, 'posted', 'first_post_created_at');
        $this->renameColumn($this->table, 'poster', 'first_post_username');
        $this->renameColumn($this->table, 'last_post', 'last_post_created_at');
        $this->renameColumn($this->table, 'last_poster', 'last_post_username');
        $this->renameColumn($this->table, 'sticky', 'sticked');
        $this->renameColumn($this->table, 'num_views', 'number_views');
        $this->renameColumn($this->table, 'num_replies', 'number_posts');

        $this->addColumn($this->table, 'first_post_user_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->addColumn($this->table, 'last_post_user_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->alterColumn($this->table, 'subject', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn($this->table, 'first_post_username', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn($this->table, 'last_post_username', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn($this->table, 'first_post_created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'number_views', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'number_posts', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'first_post_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'last_post_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'last_post_created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'forum_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'closed', Schema::TYPE_BOOLEAN . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'sticked', Schema::TYPE_BOOLEAN . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'forum_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->rebuildFirstPosterColumn();
        $this->rebuildLastPosterColumn();
    }

    protected function rebuildFirstPosterColumn()
    {
        $this->execute('
            UPDATE topic t, (
                SELECT id, username FROM users
            ) u
            SET t.first_post_user_id = u.id
            WHERE t.first_post_username = u.username AND t.first_post_username IS NOT NULL
        ');
    }

    protected function rebuildLastPosterColumn()
    {
        $this->execute('
            UPDATE topic t, (
                SELECT id, username FROM users
            ) u
            SET t.last_post_user_id = u.id
            WHERE t.last_post_username = u.username AND t.last_post_username IS NOT NULL
        ');
    }
}
