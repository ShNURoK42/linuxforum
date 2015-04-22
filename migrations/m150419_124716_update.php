<?php

use yii\db\Schema;
use yii\db\Migration;

class m150419_124716_update extends Migration
{
    public function up()
    {
        $this->renameTable('{{%online}}', '{{%user_online}}');
    }

    public function down()
    {
        echo "m150419_124716_update cannot be reverted.\n";

        return false;
    }
}
