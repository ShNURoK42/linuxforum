<?php

namespace user\models;

use Yii;

class NotifyForm extends \yii\base\Model
{
    /**
     * @var string
     */
    public $notify_mention_email;
    /**
     * @var string
     */
    public $notify_mention_web;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['notify_mention_email', 'boolean'],
            ['notify_mention_web', 'boolean'],
        ];
    }
}