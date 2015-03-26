<?php

namespace app\components\auth;

use Yii;
use app\models\User;

class Rules extends \yii\base\Object
{
    /**
     * @var User
     */
    public $user;
    /**
     * @var string
     */
    public $role;

    public function init()
    {
        $this->user = Yii::$app->getUser()->getIdentity();
        $this->role = $this->user->role;
    }

    public function updatePostRule($item, $params)
    {
        if ($this->role == 'administrator') {
            return true;
        }

        /** @var \app\models\Post $post */
        $post = $params['post'];

        return $post->user_id === $this->user->id;
    }
}
