<?php

namespace user\models;

use Yii;
use yii\helpers\Url;
use captcha\behaviors\CaptchaBehavior;

/**
 * Model of user authorization form.
 *
 * @property boolean $isShow
 * @property integer $duration
 */
class LoginForm extends \yii\base\Model
{
    /**
     * @var string user email.
     */
    public $email;
    /**
     * @var string user password.
     */
    public $password;
    /**
     * @var boolean whether to remember user log in status.
     */
    public $remember = true;
    /**
     * @var string captcha
     */
    public $verifyCode;
    /**
     * @var integer number of seconds that the user can remain in logged-in status.
     */
    private $_duartion;
    /**
     * @var User current user model.
     */
    private $_user = null;

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
            //['email', 'exist', 'targetClass' => User::className(), 'message' => Yii::t('app/form', 'Exist email')],

            ['password', 'trim'],
            ['password', 'required', 'message' => Yii::t('app/form', 'Required password')],
            ['password', 'string', 'min' => 6, 'tooShort' => Yii::t('app/form', 'String short password')],
            ['password', 'string', 'max' => 32, 'tooLong' => Yii::t('app/form', 'String long password')],
            ['password', 'passwordValidation'],

            ['remember', 'boolean'],

            ['verifyCode', 'required', 'message' => 'Введите код безопасности с изображения.'],
            ['verifyCode', 'captcha', 'captchaAction' => '/captcha/default/index', 'message' => 'Код безопасности указан неверно.'],
        ];
    }

    /**
     * Validate password attribute given by form.
     * @param string $attribute password attribute.
     */
    public function passwordValidation($attribute)
    {
        if ($this->hasErrors('email')) {
            return;
        }

        $user = $this->getUser();
        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $user->password_hash, $matches) || $matches[1] < 4 || $matches[1] > 30) {
            $this->addError($attribute, 'На сайте введена новая система аутентификации, для входа вам необходимо <a href="' . Url::toRoute('/user/forget/index') . '">сменить</a> свой пароль!');
            return;
        }

        if (!$user || !Yii::$app->security->validatePassword($this->$attribute, $user->password_hash)) {
            $this->addError($attribute, Yii::t('app/form', 'Wrong email/password'));
            return;
        }
    }

    /**
     * Logs in a user.
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->getDuration());
        }

        return false;
    }

    /**
     * Set number in seconds that the user can remain in logged-in status.
     * @param integer $duartion number in seconds.
     * @return self
     */
    public function setDuration($duartion)
    {
        $this->_duartion = $duartion;

        return $this;
    }

    /**
     * Returns number in seconds that the user can remain in logged-in status.
     * @return integer number in seconds.
     */
    public function getDuration()
    {
        if (!isset($this->_duartion)) {
            $this->_duartion = 1209600;
        }

        return $this->_duartion;
    }

    /**
     * Finds user model by the form given username.
     * @return User|null current user model.
     * If null, it means the current user model will be not found with this username.
     */
    public function getUser()
    {
        if (!$this->_user instanceof User) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
}