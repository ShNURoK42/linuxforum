<?php

use yii\db\Schema;
use yii\db\Migration;

class m150425_083444_update_user extends Migration
{
    public $table = '{{%user}}';

    public function up()
    {
        $this->addColumn($this->table, 'notify_mention_email', Schema::TYPE_BOOLEAN);
        $this->addColumn($this->table, 'notify_mention_web', Schema::TYPE_BOOLEAN);

        $this->alterColumn($this->table, 'notify_mention_email', Schema::TYPE_BOOLEAN . ' NOT NULL AFTER number_posts');
        $this->alterColumn($this->table, 'notify_mention_web', Schema::TYPE_BOOLEAN . ' NOT NULL AFTER notify_mention_email');

        $this->execute('UPDATE ' . $this->table . ' SET notify_mention_email = 1');
        $this->execute('UPDATE ' . $this->table . ' SET notify_mention_web = 1');
    }

    public function down()
    {
        echo "m150425_083444_update_user cannot be reverted.\n";

        return false;
    }
}
