<?php

use yii\db\Schema;
use yii\db\Migration;

class m150716_134230_rebuild extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE user CHANGE id id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->execute("UPDATE user SET id = 0 WHERE id = 5");
        $this->execute("UPDATE user SET username='anindefinite' WHERE id=0");

        $this->dropIndex('posts_topic_id_idx', 'post');
        $this->dropIndex('posts_multi_idx', 'post');
        $this->dropIndex('posts_posted_idx', 'post');

        $this->createIndex('user_id_idx', 'post', 'user_id');

        $this->execute("UPDATE post SET user_id = 0 WHERE user_id NOT IN (SELECT u.id FROM user u)");
        $this->execute("ALTER TABLE post ADD FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE ON UPDATE CASCADE");

    }
}
