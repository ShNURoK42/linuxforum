<?php

use yii\db\Migration;

class m150824_054207_user2 extends Migration
{

    public function up()
    {
        $users = $this->db->createCommand('SELECT id, created_at FROM user2');
        $users = $users->queryAll();
        $count = sizeof($users);

        $i = 1;
        foreach ($users as $user) {
            $command = $this->db->createCommand('SELECT count(*) FROM post WHERE user_id=:user_id');
            $command->bindParam(':user_id', $user['id']);

            if ($command->queryScalar()) {
                $command2 = $this->db->createCommand('SELECT user_ip FROM post WHERE user_id=:user_id LIMIT 1');
                $command2->bindParam(':user_id', $user['id']);
                $post = $command2->queryOne();

                $command3 = $this->db->createCommand('UPDATE user2 SET ip=:ip WHERE id=:user_id');
                $command3->bindParam(':user_id', $user['id']);
                $command3->bindParam(':ip', long2ip($post['user_ip']));
                $command3->execute();
            }

            $date = date("Y-m-d H:i:s",  $user['created_at']);
            $command4 = $this->db->createCommand('UPDATE user2 SET created_at=:created_at WHERE id=:user_id');
            $command4->bindParam(':created_at', $date);
            $command4->bindParam(':user_id', $user['id']);
            $command4->execute();

            if ($i % 100 == 0) {
                echo "User number: $i from $count\n";
            }
            $i++;
        }
    }
}
