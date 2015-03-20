<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055004_update_categories extends Migration
{
    protected $table = '{{%category_group}}';

    public function up()
    {
        $this->renameTable('{{%categories}}', $this->table);

        $this->renameColumn($this->table, 'cat_name', 'name');
        $this->renameColumn($this->table, 'disp_position', 'display_position');

        $this->alterColumn($this->table, 'name', Schema::TYPE_STRING . '(64) NOT NULL');
        $this->alterColumn($this->table, 'display_position', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
    }

    public function down()
    {
        echo "m141019_055004_update_categories cannot be reverted.\n";

        return false;
    }
}
