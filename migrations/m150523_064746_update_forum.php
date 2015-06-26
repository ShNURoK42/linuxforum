<?php

use yii\db\Schema;
use yii\db\Migration;

class m150523_064746_update_forum extends Migration
{
    public function up()
    {
        // There you can convert forum_id to tag sysrem.
        /*
        $topics = $this->db
            ->createCommand('SELECT id, forum_id FROM topic')
            ->queryAll();

        foreach ($topics as $topic) {
            if ($topic['forum_id'] == 1) {
                $this->insert('{{%tag_topic_assignment}}', [
                    'tag_name' => 'default',
                    'topic_id' => $topic['id'],
                ]);
            }
        }
        */

        $this->dropColumn('{{%topic}}', 'forum_id');
    }

    public function down()
    {
        echo "m150523_064746_update_forum cannot be reverted.\n";

        return false;
    }
}
