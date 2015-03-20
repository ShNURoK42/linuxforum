<?php

use yii\db\Schema;
use yii\db\Migration;

class m150318_013715_fix_moved_to extends Migration
{
    public function up()
    {
        $this->execute('DELETE FROM topics WHERE topics.moved_to NOT LIKE 0');
    }
}
