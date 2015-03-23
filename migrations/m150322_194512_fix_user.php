<?php

use yii\db\Schema;
use yii\db\Migration;

class m150322_194512_fix_user extends Migration
{
    protected $table = '{{%user}}';

    public function up()
    {
        $this->renameTable('{{%users}}', $this->table);

        $this->renameColumn($this->table, 'num_posts', 'number_posts');
        $this->renameColumn($this->table, 'registered', 'created_at');
        $this->renameColumn($this->table, 'last_post', 'last_posted_at');
        $this->renameColumn($this->table, 'last_visit', 'last_visited_at');
        $this->renameColumn($this->table, 'signature', 'about');

        $this->addColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->addColumn($this->table, 'role_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY role_id INTEGER(11) UNSIGNED NOT NULL AFTER id');

        $this->alterColumn($this->table, 'username', Schema::TYPE_STRING . '(32) NOT NULL');
        $this->alterColumn($this->table, 'email', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn($this->table, 'number_posts', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'last_posted_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');
        $this->alterColumn($this->table, 'last_visited_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');


        $this->dropColumn($this->table, 'group_id');
        $this->dropColumn($this->table, 'title');
        $this->dropColumn($this->table, 'realname');
        $this->dropColumn($this->table, 'url');
        $this->dropColumn($this->table, 'facebook');
        $this->dropColumn($this->table, 'twitter');
        $this->dropColumn($this->table, 'linkedin');
        $this->dropColumn($this->table, 'skype');
        $this->dropColumn($this->table, 'jabber');
        $this->dropColumn($this->table, 'icq');
        $this->dropColumn($this->table, 'msn');
        $this->dropColumn($this->table, 'aim');
        $this->dropColumn($this->table, 'yahoo');
        $this->dropColumn($this->table, 'location');
        $this->dropColumn($this->table, 'disp_topics');
        $this->dropColumn($this->table, 'disp_posts');
        $this->dropColumn($this->table, 'email_setting');
        $this->dropColumn($this->table, 'notify_with_post');
        $this->dropColumn($this->table, 'auto_notify');
        $this->dropColumn($this->table, 'show_smilies');
        $this->dropColumn($this->table, 'show_img');
        $this->dropColumn($this->table, 'show_img_sig');
        $this->dropColumn($this->table, 'show_avatars');
        $this->dropColumn($this->table, 'show_sig');
        $this->dropColumn($this->table, 'access_keys');
        $this->dropColumn($this->table, 'dst');
        $this->dropColumn($this->table, 'time_format');
        $this->dropColumn($this->table, 'date_format');
        $this->dropColumn($this->table, 'language');
        $this->dropColumn($this->table, 'style');
        $this->dropColumn($this->table, 'last_search');
        $this->dropColumn($this->table, 'registration_ip');

        $this->dropColumn($this->table, 'avatar');
        $this->dropColumn($this->table, 'avatar_width');
        $this->dropColumn($this->table, 'avatar_height');

        // удаляем гостя
        $this->execute('DELETE FROM {{%user}} WHERE id = 1');

        // удаляем индексы
        $this->dropIndex('users_registered_idx', $this->table);
        $this->dropIndex('users_username_idx', $this->table);
        $this->dropIndex('users_last_visit_idx', $this->table);

        $this->execute('UPDATE user SET role_id = 3');

        $this->rebuildRegisteredIP();
        $this->rebuildSignature();
    }

    protected function rebuildRegisteredIP()
    {
        $query = $this->db->createCommand('SELECT id, registration_ip FROM user');
        $users = $query->queryAll();
        $count = sizeof($users);

        $i = 1;
        foreach ($users as $user) {
            $ip = ip2long($user['registration_ip']);

            $command = $this->db->createCommand('UPDATE user SET registration_ip=:registration_ip WHERE id=:id');
            $command->bindParam(':id', $user['id']);
            $command->bindParam(':registration_ip', $ip);
            $command->execute();

            if ($i % 10000 == 0) {
                echo "Posts number: $i from $count\n";
            }
            $i++;
        }

        $this->alterColumn($this->table, 'registration_ip', Schema::TYPE_INTEGER . ' NOT NULL');
    }

    public function rebuildSignature()
    {
        $users = $this->db->createCommand('SELECT id, about FROM user');
        $users = $users->queryAll();
        $count = sizeof($users);

        $i = 1;
        foreach ($users as $user) {
            $new_text = $this->bbcode($user['about']);
            $command = $this->db->createCommand('UPDATE user SET about=:about WHERE id=:id');
            $command->bindParam(':id', $user['id']);
            $command->bindParam(':about', $new_text);
            $command->execute();

            if ($i % 1000 == 0) {
                echo "Post number: $i from $count\n";
            }
            $i++;
        }
    }

    protected function bbcode($bbcode)
    {
        $bbcode = str_replace("\n", "  \n", $bbcode);

        $bbcode = str_replace("[hr]", "", $bbcode);

        $bbcode = str_replace("[b]", "**", $bbcode);
        $bbcode = str_replace("[/b]", "**", $bbcode);

        $bbcode = str_replace("[i]", "*", $bbcode);
        $bbcode = str_replace("[/i]", "*", $bbcode);

        $bbcode = str_replace("[s]", "", $bbcode);
        $bbcode = str_replace("[/s]", "", $bbcode);

        $bbcode = str_replace("[u]", "", $bbcode);
        $bbcode = str_replace("[/u]", "", $bbcode);

        // [color]
        $bbcode = preg_replace_callback('/\[color=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[\/color\]/s',
            function ($matches) {
                return $matches[2];
            },
            $bbcode
        );
        // [url]
        $bbcode = preg_replace_callback('/\[url\](.*?)\[\/url\]/s',
            function ($matches) {
                return "<" . $matches[1] . ">";
            },
            $bbcode
        );
        $bbcode = preg_replace_callback('/\[url\=(.*?)\](.*?)\[\/url\]/s',
            function ($matches) {
                return "[" . $matches[2] . "](" . $matches[1] . ")";
            },
            $bbcode
        );

        return $bbcode;
    }
}
