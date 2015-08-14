<?php

use yii\db\Migration;

class m150731_132804_post_topic_id_idx extends Migration
{
    public function up()
    {
        $this->createIndex('topic_id_idx', '{{%post}}', 'topic_id');
    }
}
