<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055007_update_posts extends Migration
{
    protected $table = '{{%post}}';

    public function up()
    {
        $this->renameTable('{{%posts}}', $this->table);

        $this->dropColumn($this->table, 'poster');
        $this->dropColumn($this->table, 'poster_ip');
        $this->dropColumn($this->table, 'poster_email');
        $this->dropColumn($this->table, 'hide_smilies');
        $this->dropColumn($this->table, 'edited_by');

        $this->renameColumn($this->table, 'poster_id', 'user_id');
        $this->renameColumn($this->table, 'posted', 'created_at');
        $this->renameColumn($this->table, 'edited', 'updated_at');
        $this->renameColumn($this->table, 'message', 'text');
        $this->renameColumn($this->table, 'topic_id', 'question_id');

        $this->addColumn($this->table, 'updated_by', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->addColumn($this->table, 'status_id', Schema::TYPE_INTEGER . '(1) NOT NULL');
        $this->alterColumn($this->table, 'user_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY question_id INTEGER(11) UNSIGNED NOT NULL AFTER id');
    }

    public function down()
    {
        echo "m141019_055007_update_posts cannot be reverted.\n";

        return false;
    }
}
