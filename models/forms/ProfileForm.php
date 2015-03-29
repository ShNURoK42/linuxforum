<?php

namespace app\models\forms;

use Yii;

class ProfileForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $message;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['message', 'trim'],
            ['message', 'required', 'message' => Yii::t('app/form', 'Required message')],
            ['message', 'string', 'min' => 6, 'tooShort' => Yii::t('app/form', 'String short topic message')],
            ['message', 'string', 'max' => 1000, 'tooLong' => Yii::t('app/form', 'String long topic message')],
        ];
    }
}