<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_055005_update_users extends Migration
{
    protected $table = '{{%user}}';

    public function up()
    {
        $this->renameTable('{{%users}}', $this->table);

        $this->renameColumn($this->table, 'salt', 'auth_key');
        $this->renameColumn($this->table, 'num_posts', 'number_posts');
        $this->renameColumn($this->table, 'registered', 'created_at');
        $this->renameColumn($this->table, 'password', 'password_hash');


        $this->addColumn($this->table, 'updated_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->alterColumn($this->table, 'created_at', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        $this->addColumn($this->table, 'password_change_token', Schema::TYPE_STRING . '(64)');
        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY password_change_token VARCHAR(64) AFTER password_hash');

        $this->addColumn($this->table, 'password_changed_at', Schema::TYPE_INTEGER . ' UNSIGNED');
        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY password_changed_at INTEGER(11) UNSIGNED AFTER password_change_token');

        $this->addColumn($this->table, 'role_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->execute('ALTER TABLE ' . $this->table . ' MODIFY role_id INTEGER(11) UNSIGNED NOT NULL AFTER id');


        $this->alterColumn($this->table, 'auth_key', Schema::TYPE_STRING . '(32) NOT NULL');
        $this->alterColumn($this->table, 'password_hash', Schema::TYPE_STRING . '(60) NOT NULL');
        $this->alterColumn($this->table, 'username', Schema::TYPE_STRING . '(40) NOT NULL');
        $this->alterColumn($this->table, 'email', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn($this->table, 'number_posts', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0');

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
        $this->dropColumn($this->table, 'signature');
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
        $this->dropColumn($this->table, 'timezone');
        $this->dropColumn($this->table, 'dst');
        $this->dropColumn($this->table, 'time_format');
        $this->dropColumn($this->table, 'date_format');
        $this->dropColumn($this->table, 'language');
        $this->dropColumn($this->table, 'style');
        $this->dropColumn($this->table, 'last_post');
        $this->dropColumn($this->table, 'last_search');
        $this->dropColumn($this->table, 'last_email_sent');
        $this->dropColumn($this->table, 'registration_ip');
        $this->dropColumn($this->table, 'last_visit');
        $this->dropColumn($this->table, 'admin_note');
        $this->dropColumn($this->table, 'activate_string');
        $this->dropColumn($this->table, 'activate_key');
        $this->dropColumn($this->table, 'pun_pm_new_messages');
        $this->dropColumn($this->table, 'pun_pm_long_subject');
        $this->dropColumn($this->table, 'pun_bbcode_enabled');
        $this->dropColumn($this->table, 'pun_bbcode_use_buttons');
        $this->dropColumn($this->table, 'rep_enable');
        $this->dropColumn($this->table, 'rep_disable_adm');
        $this->dropColumn($this->table, 'rep_minus');
        $this->dropColumn($this->table, 'rep_plus');
        $this->dropColumn($this->table, 'distr');
        $this->dropColumn($this->table, 'show_subforums_list');
        $this->dropColumn($this->table, 'avatar');
        $this->dropColumn($this->table, 'avatar_width');
        $this->dropColumn($this->table, 'avatar_height');
        $this->dropColumn($this->table, 'loginza_identity');
        $this->dropColumn($this->table, 'loginza_uid');
        $this->dropColumn($this->table, 'loginza_provider');
        $this->dropColumn($this->table, 'stick_favorites');
        $this->dropColumn($this->table, 'fancy_stop_spam_bot');
        $this->dropColumn($this->table, 'enable_pm_email');
        $this->dropColumn($this->table, 'birthday');
        $this->dropColumn($this->table, 'bday_email');

        // удаляем гостя
        $this->execute('DELETE FROM {{%user}} WHERE id = 1');

        // удаляем индексы
        $this->dropIndex('users_registered_idx', $this->table);
        $this->dropIndex('users_username_idx', $this->table);
    }

    public function down()
    {
        echo "m141019_055005_update_users cannot be reverted.\n";

        return false;
    }
}
