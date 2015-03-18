<?php

namespace app\components;

class Security extends \yii\base\Security
{
    public function generatePasswordHashForum($string, $salt)
    {
        return sha1($salt . sha1($string));
    }

    public function generateSalt($length = 12)
    {
        return $this->generateRandomString(12);
    }
}