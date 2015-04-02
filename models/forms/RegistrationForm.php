<?php

namespace app\models\forms;

use Yii;
use app\models\User;
use app\behaviors\CaptchaBehavior;

/**
 * Model of user registration form.
 *
 * @property boolean $isShow
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
    public $termsAgree;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $repassword;
    /**
     * @var string captcha
     */
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'captchaBehavior' => [
                'class' => CaptchaBehavior::className(),
            ],
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
            ['username', 'string', 'max' => 40, 'tooLong' => Yii::t('app/form', 'String long username')],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]/', 'message' => Yii::t('app/form', 'Username match first letter')],
            ['username', 'match', 'pattern' => '/^[\w-]+$/', 'message' => Yii::t('app/form', 'Username match common')],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app/form', 'Unique username')],

            ['password', 'required', 'message' => 'Введите пароль.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум {min} символа.'],
            ['password', 'string', 'max' => 32, 'tooLong' => 'Пароль не должен быть длиннее {max} символов.'],

            ['repassword', 'required', 'message' => 'Введите пароль повторно.'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают.'],

            // Rules page
            ['termsAgree', 'boolean'],
            ['termsAgree', 'required', 'requiredValue' => true, 'message' => 'Вам необходимо согласиться с правилами сайта.'],

            ['verifyCode', 'required', 'message' => 'Введите код безопасности с изображения.'],
            ['verifyCode', 'captcha', 'message' => 'Код безопасности указан неверно.'],
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

            $user->role = 'user';
            $user->username = $this->username;
            $user->email = $this->email;
            $user->email_status = User::EMAIL_STATUS_INACTIVE;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->last_visited_at = time();

            if ($this->sendMail($user)) {
                return $user->save();
            }
        }

        return false;
    }

    /**
     * Send registration mail.
     * @param User $user
     * @return boolean
     */
    public function sendMail($user)
    {
        return \Yii::$app->mailer->compose(['text' => 'register'], ['user' => $user])
            ->setFrom([Yii::$app->config->get('support_email') => Yii::$app->config->get('site_title')])
            ->setTo([$this->email => $user->username])
            ->setSubject('[' . Yii::$app->config->get('site_title') . '] Благодарим Вас за регистрацию!')
            ->send();
    }
}