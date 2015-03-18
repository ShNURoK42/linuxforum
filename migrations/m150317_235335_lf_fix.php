<?php

use yii\db\Schema;
use yii\db\Migration;

class m150317_235335_lf_fix extends Migration
{
    public function up()
    {
        $this->execute('DELETE posts, topics FROM posts INNER JOIN topics INNER JOIN forums WHERE posts.topic_id = topics.id AND topics.forum_id = forums.id AND forums.id = 41');
        $this->execute('DELETE posts, topics FROM posts INNER JOIN topics INNER JOIN forums WHERE posts.topic_id = topics.id AND topics.forum_id = forums.id AND forums.id = 52');
        $this->execute('DELETE posts, topics FROM posts INNER JOIN topics INNER JOIN forums WHERE posts.topic_id = topics.id AND topics.forum_id = forums.id AND forums.id = 3');

        $this->execute('DELETE FROM forums WHERE forums.id = 41');
        $this->execute('DELETE FROM forums WHERE forums.id = 52');

        $this->execute('DELETE FROM categories WHERE categories.id = 6');

        $this->execute('UPDATE forums SET num_posts = 0 WHERE forums.id = 3');
        $this->execute('UPDATE forums SET num_topics = 0 WHERE forums.id = 3');
        $this->execute('UPDATE forums SET last_post = 0 WHERE forums.id = 3');
        $this->execute('UPDATE forums SET last_post_id = 0 WHERE forums.id = 3');
        $this->execute('UPDATE forums SET last_poster = \'\' WHERE forums.id = 3');

        $this->execute('DELETE FROM groups WHERE groups.g_id > 4');

        $this->execute('UPDATE users SET group_id = 3');
    }
}
