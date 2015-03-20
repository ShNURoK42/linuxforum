<?php

use yii\db\Schema;
use yii\db\Migration;

class m141021_055001_rebuild_index extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%category}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%category}}');
        $this->execute('ALTER TABLE {{%category}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%category}}', 'id2', Schema::TYPE_PK . ' FIRST');

        $this->alterColumn('{{%category_group}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%category_group}}');
        $this->execute('ALTER TABLE {{%category_group}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%category_group}}', 'id2', Schema::TYPE_PK . ' FIRST');

        $this->alterColumn('{{%user}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%user}}');
        $this->execute('ALTER TABLE {{%user}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%user}}', 'id2', Schema::TYPE_PK . ' FIRST');

        $this->alterColumn('{{%post}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%post}}');
        $this->execute('ALTER TABLE {{%post}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%post}}', 'id2', Schema::TYPE_PK . ' FIRST');

        $this->alterColumn('{{%question}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%question}}');
        $this->execute('ALTER TABLE {{%question}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%question}}', 'id2', Schema::TYPE_PK . ' FIRST');

        $this->alterColumn('{{%private_message}}', 'id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');
        $this->dropPrimaryKey('id', '{{%private_message}}');
        $this->execute('ALTER TABLE {{%private_message}} AUTO_INCREMENT = 1');
        $this->addColumn('{{%private_message}}', 'id2', Schema::TYPE_PK . ' FIRST');


        // rebuild section
        // category.group_id
        $this->execute('
            UPDATE category c, (
                SELECT id, id2 FROM category_group
            ) cg
            SET c.group_id = cg.id2
            WHERE c.group_id = cg.id
        ');

        // question.user_id
        $this->execute('
            UPDATE question t, (
                SELECT id, id2, username FROM user
            ) u
            SET t.user_id = u.id2
            WHERE t.user_id = u.username
        ');
        // удаляем вопросы удаленных пользователей
        $this->execute('
            DELETE FROM question WHERE id IN (
                SELECT * FROM (
                    SELECT id FROM question WHERE user_id NOT REGEXP \'^[0-9]+$\'
                ) AS t
            )
        ');
        // question.category_id
        $this->execute('
            UPDATE question q, (
                SELECT id, id2 FROM category
            ) c
            SET q.category_id = c.id2
            WHERE q.category_id = c.id
        ');
        $this->alterColumn('{{%question}}', 'user_id', Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL');

        // post.question_id
        $this->execute('
            UPDATE post p, (
                SELECT id, id2 FROM question
            ) q
            SET p.question_id = q.id2
            WHERE p.question_id = q.id
        ');
        // post.user_id
        $this->execute('
            UPDATE post p, (
                SELECT id, id2 FROM user
            ) u
            SET p.user_id = u.id2
            WHERE p.user_id = u.id
        ');

        // private_message.sender_id
        $this->execute('
            UPDATE private_message pm, (
                SELECT id, id2 FROM user
            ) u
            SET pm.sender_id = u.id2
            WHERE pm.sender_id = u.id
        ');
        // private_message.receiver_id
        $this->execute('
            UPDATE private_message pm, (
                SELECT id, id2 FROM user
            ) u
            SET pm.receiver_id = u.id2
            WHERE pm.receiver_id = u.id
        ');


        // delete id and id2
        $this->dropColumn('{{%category}}', 'id');
        $this->renameColumn('{{%category}}', 'id2', 'id');

        $this->dropColumn('{{%category_group}}', 'id');
        $this->renameColumn('{{%category_group}}', 'id2', 'id');

        $this->dropColumn('{{%user}}', 'id');
        $this->renameColumn('{{%user}}', 'id2', 'id');

        $this->dropColumn('{{%post}}', 'id');
        $this->renameColumn('{{%post}}', 'id2', 'id');

        $this->dropColumn('{{%question}}', 'id');
        $this->renameColumn('{{%question}}', 'id2', 'id');

        $this->dropColumn('{{%private_message}}', 'id');
        $this->renameColumn('{{%private_message}}', 'id2', 'id');
    }

    public function down()
    {
        echo "m141021_055001_rebuild_index cannot be reverted.\n";

        return false;
    }
}
