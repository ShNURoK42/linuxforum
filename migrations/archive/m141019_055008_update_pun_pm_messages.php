<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055008_update_pun_pm_messages extends Migration
{
    protected $table = '{{%private_message}}';

    public function up()
    {
        $this->renameTable('{{%pun_pm_messages}}', $this->table);

        $this->dropColumn($this->table, 'status');

        $this->renameColumn($this->table, 'read_at', 'sended_at');
        $this->renameColumn($this->table, 'lastedited_at', 'created_at');

        $this->addColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'sended_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

    }

    public function down()
    {
        echo "m141019_055008_update_pun_pm_messages cannot be reverted.\n";

        return false;
    }
}
