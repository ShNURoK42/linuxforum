<?php

namespace user\models;

class UserRepository
{
    public function createByRegisrationForm($params)
    {

    }

    protected function create($user)
    {

    }

    public function getUserByEmail($email)
    {
        return User::findOne(['email' => $email]);
    }
}