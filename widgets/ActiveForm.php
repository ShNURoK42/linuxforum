<?php

namespace app\widgets;

use yii\widgets\ActiveForm as YiiActiveForm;

class ActiveForm extends YiiActiveForm
{
    /**
     * @inheritdoc
     */
    public $fieldClass = 'app\widgets\ActiveField';
    /**
     * @inheritdoc
     */
    public $encodeErrorSummary = false;
    /**
     * @inheritdoc
     */
    public $enableClientValidation = false;
    /**
     * @inheritdoc
     */
    public $enableClientScript = false;
}