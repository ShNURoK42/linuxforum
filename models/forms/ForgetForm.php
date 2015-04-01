<?php

namespace app\models\forms;

use Yii;
use app\models\User;

/**
 * Model of user password recovery.
 *
 * @property User $user
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
     * @var User $_user
     */
    private $_user;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'email' => ['email'],
            'token' => ['token'],
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
            ['token', 'string', 'length' => 8],
        ];
    }

    /**
     * Check flud.
     * @return boolean
     */
    public function isRequestFlud()
    {
        return (time() - $this->user->last_email_sent) < 3600;
    }

    /**
     * Recovery password.
     * @return boolean
     */
    public function recoveryPassword()
    {
        $password = Yii::$app->security->generateRandomString(12);
        $token = Yii::$app->security->generateRandomString(8);

        if ($this->sendMail($password, $token)) {
            $user = $this->user;
            $user->activate_key = $token;
            $user->activate_string = $password;
            $user->last_email_sent = time();

            return $user->save();
        }

        return false;
    }

    /**
     * Updated user password.
     * @return boolean
     */
    public function updatePassword()
    {
        $user = $this->user;

        if ((time() - $user->last_email_sent) < 86400) {
            $salt = Yii::$app->security->generateSalt();
            $user->password = Yii::$app->security->generatePasswordHashForum($user->activate_string, $salt);
            $user->activate_string = null;
            $user->activate_key = null;
            $user->last_email_sent = null;
            $user->salt = $salt;

            return $user->save();
        }

        return false;
    }

    /**
     * Send mail.
     * @param $password
     * @param $token
     * @return boolean
     */
    protected function sendMail($password, $token)
    {
        $user = $this->user;

        return \Yii::$app->mailer->compose(['text' => 'forget'], ['user' => $user, 'password' => $password, 'token' => $token])
            ->setFrom([Yii::$app->config->get('support_email') => Yii::$app->config->get('site_title')])
            ->setTo([$this->email => $user->username])
            ->setSubject('[' . Yii::$app->config->get('site_title') . '] Запрос на смену пароля')
            ->send();
    }

    /**
     * Finds user model by the form given username.
     * @return User|null current user model.
     * If null, it means the current user model will be not found with this username.
     */
    protected function getUser()
    {
        if (!isset($this->_user)) {
            if ($this->scenario == 'email') {
                $this->_user = User::findByEmail($this->email);
            } elseif ($this->scenario == 'token') {
                $this->_user = User::findOne(['activate_key' => $this->token]);
            }
        }
        return $this->_user;
    }
}