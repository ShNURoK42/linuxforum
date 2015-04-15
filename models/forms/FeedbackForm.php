<?php

namespace app\models\forms;

use Yii;
use app\behaviors\CaptchaBehavior;

/**
 * Модель формы обратной связи.
 *
 * @property string $email
 * @property string $username
 */
class FeedbackForm extends \yii\base\Model
{
    /**
     * Имя пользователя.
     *
     * @var string
     */
    public $name;
    /**
     * Электроннная почта пользователя.
     *
     * @var string
     */
    public $email;
    /**
     * Текст сообщения.
     *
     * @var string
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => 'Введите имя пользователя.'],
            ['name', 'string', 'min' => 2, 'tooShort' => 'Имя пользователя должно содержать минимум {min} символа.'],
            ['name', 'string', 'max' => 40, 'tooLong' => 'Имя пользователя не должно быть длиннее {max} символов.'],

            ['email', 'required', 'message' => 'Введите адрес электронной почты.'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'enableIDN' => true, 'message' => 'Введеный адрес электронной почты неверен.'],

            ['message', 'filter', 'filter' => 'trim'],
            ['message', 'required', 'message' => 'Введите текст сообщения.'],
        ];
    }

    public function contact()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose(['text' => 'feedback'], [
                'name' => $this->name,
                'email' => $this->email,
                'message' => $this->message,
            ])
                ->setTo([Yii::$app->config->get('support_email') => 'Administrator'])
                ->setFrom([Yii::$app->config->get('support_email') => $this->name])
                ->setSubject('[' . Yii::$app->config->get('site_title') . '] Форма обратной связи')
                ->send();

            return true;
        } else {
            return false;
        }
    }
}