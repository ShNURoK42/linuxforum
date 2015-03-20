<?php

use yii\db\Schema;
use yii\db\Migration;

class m150320_093522_fix_post extends Migration
{
    protected $table = '{{%post}}';

    public function up()
    {
        $this->renameTable('{{%posts}}', $this->table);

        $this->dropColumn($this->table, 'poster');
        $this->dropColumn($this->table, 'poster_email');
        $this->dropColumn($this->table, 'hide_smilies');
        $this->dropColumn($this->table, 'edited');
        $this->dropColumn($this->table, 'edited_by');

        $this->renameColumn($this->table, 'poster_id', 'user_id');
        $this->renameColumn($this->table, 'poster_ip', 'user_ip');
        $this->renameColumn($this->table, 'posted', 'created_at');

        $this->addColumn($this->table, 'status', Schema::TYPE_INTEGER . '(1) NOT NULL');
        $this->addColumn($this->table, 'edited_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->addColumn($this->table, 'edited_by', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');

        $this->alterColumn($this->table, 'message', Schema::TYPE_TEXT . ' CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
        $this->alterColumn($this->table, 'topic_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'user_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'edited_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');

        $this->rebuildUserIP();

        $this->execute('ALTER TABLE post ENGINE = InnoDB;');
    }

    protected function rebuildUserIP()
    {
        $query = $this->db->createCommand('SELECT id, user_ip FROM post');
        $posts = $query->queryAll();
        $count = sizeof($posts);

        $i = 1;
        foreach ($posts as $post) {
            $user_ip = ip2long($post['user_ip']);

            $command = $this->db->createCommand('UPDATE post SET user_ip=:user_ip WHERE id=:id');
            $command->bindParam(':id', $post['id']);
            $command->bindParam(':user_ip', $user_ip);
            $command->execute();

            if ($i % 10000 == 0) {
                echo "Posts number: $i from $count\n";
            }
            $i++;
        }

        $this->alterColumn($this->table, 'user_ip', Schema::TYPE_INTEGER . ' NOT NULL');
    }
}
