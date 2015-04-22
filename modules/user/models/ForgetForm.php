<?php

namespace user\models;

use Yii;
use captcha\behaviors\CaptchaBehavior;

/**
 * Model of user password recovery.
 *
 * @property User $user
 * @property User $isCorrectUsername
 */
class ForgetForm extends \yii\base\Model
{
    /**
     * @var string user email given by form.
     */
    public $email;
    /**
     * @var string activate key.
     */
    public $token;
    /**
     * @var string
     */
    public $username;
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
     * @var User $_user
     */
    private $_user;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'email' => ['email', 'verifyCode'],
            'token' => ['token', 'username', 'password', 'repassword'],
        ];
    }

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
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => Yii::t('app/form', 'Required email')],
            ['email', 'email', 'enableIDN' => true, 'message' => Yii::t('app/form', 'Valid email')],
            ['email', 'exist', 'targetClass' => User::className(), 'message' => Yii::t('app/form', 'Exist email')],

            ['token', 'filter', 'filter' => 'trim'],
            ['token', 'required'],
            ['token', 'string', 'length' => 32],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Введите имя.'],
            ['username', 'string', 'min' => 4, 'tooShort' => 'Ваше имя должно содержать минимум {min} символа.'],
            ['username', 'string', 'max' => 40, 'tooLong' => 'Ваше имя не должно быть длиннее {max} символов.'],
            ['username', 'match', 'pattern' => '/^[\w-]+$/', 'message' => 'В вашем имени можно использовать только латинские буквы, цифры, знаки &#171;_&#187; и &#171;-&#187;.'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z]/', 'message' => 'Первым символом в имени должна быть латинская буква.'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'Указанное вами имя занято.'],

            ['password', 'required', 'message' => 'Введите пароль.'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум {min} символа.'],
            ['password', 'string', 'max' => 32, 'tooLong' => 'Пароль не должен быть длиннее {max} символов.'],

            ['repassword', 'required', 'message' => 'Введите повторно пароль.'],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Введенные пароли не совпадают.'],

            ['verifyCode', 'required', 'message' => 'Введите код безопасности с изображения.'],
            ['verifyCode', 'captcha', 'captchaAction' => '/captcha/default/index', 'message' => 'Код безопасности указан неверно.'],
        ];
    }

    /**
     * Recovery password.
     * @return boolean
     */
    public function recovery()
    {
        $token = Yii::$app->security->generateRandomString(32);

        if ($this->sendMail($token)) {
            $user = $this->user;
            $user->password_change_token = $token;;
            $user->password_changed_at = time();

            return $user->save();
        }

        return false;
    }

    /**
     * Updated user password.
     * @return boolean
     */
    public function change()
    {
        $attributes = ['token', 'password', 'repassword'];
        if (!$this->isCorrectUsername) {
            $attributes = array_merge($attributes, ['username']);
        }

        if ($this->validate($attributes)) {
            $user = $this->getUser();

            if (!$this->isCorrectUsername) {
                $user->username = $this->username;
            }

            if ((time() - $user->password_changed_at) < 86400) {
                $user->email_status = User::EMAIL_STATUS_ACTIVE;
                $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->password_changed_at = null;
                $user->password_change_token = null;

                return $user->save();
            }
        }

        return false;
    }

    /**
     * Send mail.
     * @param $token
     * @return boolean
     */
    protected function sendMail($token)
    {
        $user = $this->user;

        return \Yii::$app->mailer->compose(['text' => 'forget'], ['user' => $user, 'token' => $token])
            ->setFrom([Yii::$app->config->get('support_email') => Yii::$app->config->get('site_title')])
            ->setTo([$this->email => $user->username])
            ->setSubject('[' . Yii::$app->config->get('site_title') . '] Запрос на смену пароля')
            ->send();
    }

    public function getIsCorrectUsername()
    {
        $username = $this->getUser()->username;


        if (!preg_match('/^[a-zA-Z][\w-]+$/', $username, $matches) || $matches[0] < 2 || $matches[0] > 40) {
            return !empty($matches[0]);
        }

        return false;
    }

    /**
     * Finds user model by the form given username.
     * @return User|null current user model.
     * If null, it means the current user model will be not found with this username.
     */
    public function getUser()
    {
        if (!isset($this->_user)) {
            if ($this->scenario == 'email') {
                $this->_user = User::findByEmail($this->email);
            } elseif ($this->scenario == 'token') {
                $this->_user = User::findOne(['password_change_token' => $this->token]);
            }
        }
        return $this->_user;
    }
}