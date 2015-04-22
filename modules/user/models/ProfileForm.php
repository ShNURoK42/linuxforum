<?php

namespace user\models;

use Yii;

class ProfileForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $timezone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['message', 'trim'],
            ['message', 'string', 'max' => 400, 'tooLong' => Yii::t('app/form', 'String long topic message')],

            ['timezone', 'timezoneValidation'],
        ];
    }

    /**
     * @param string $attribute
     */
    public function timezoneValidation($attribute)
    {
        $list = \DateTimeZone::listIdentifiers();
        if (!in_array($this->$attribute, $list)) {
            $this->addError($attribute, 'Часовой пояс указан некорректно');
            return;
        }
    }
}