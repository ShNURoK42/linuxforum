<?php

namespace app\models\forms;

use Yii;
use app\models\Group;
use app\models\User;

/**
 * Model of user registration form.
 */
class RegistrationForm extends \yii\base\Model
{
    /**
     * @var string user email given by form.
     */
    public $email;
    /**
     * @var string user username :) given by form.
     */
    public $username;
    /**
     * @var boolean
     */
    public $agree;


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'registration' => ['email', 'username'],
            'rules' => ['agree'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'required', 'message' => Yii::t('app/form', 'Required email')],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'enableIDN' => true, 'message' => Yii::t('app/form', 'Valid email')],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app/form', 'Unique email')],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => Yii::t('app/form', 'Required username')],
            ['username', 'string', 'min' => 2, 'tooShort' => Yii::t('app/form', 'String short username')],
            ['username', 'string', 'max' => 25, 'tooLong' => Yii::t('app/form', 'String long username')],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]/', 'message' => Yii::t('app/form', 'Username match first letter')],
            ['username', 'match', 'pattern' => '/^[\w-]+$/', 'message' => Yii::t('app/form', 'Username match common')],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app/form', 'Unique username')],

            // Rules page
            ['agree', 'boolean'],
            ['agree', 'required'],
        ];
    }

    /**
     * User registration.
     *
     * @return boolean
     */
    public function registration()
    {
        if ($this->validate()) {
            $user = new User();
            $password = Yii::$app->security->generateRandomString(12);

            $user->role_id = Group::GROUP_UNVERIFIED;
            $user->username = $this->username;
            $user->email = $this->email;
            $user->salt = Yii::$app->security->generateSalt();
            $user->password = Yii::$app->security->generatePasswordHashForum($password, $user->salt);
            $user->created_at = time();
            $user->last_visited_at = time();

            if ($this->sendMail($user, $password)) {
                return $user->save();
            }
        }

        return false;
    }

    /**
     * Send registration mail.
     * @param User $user
     * @param string $password
     * @return boolean
     */
    public function sendMail($user, $password)
    {
        return \Yii::$app->mailer->compose(['text' => 'register'], ['user' => $user, 'password' => $password])
            ->setFrom([Yii::$app->config->get('o_webmaster_email') => Yii::$app->config->get('o_board_title')])
            ->setTo([$this->email => $user->username])
            ->setSubject('[' . Yii::$app->config->get('o_board_title') . '] Благодарим Вас за регистрацию!')
            ->send();
    }
}