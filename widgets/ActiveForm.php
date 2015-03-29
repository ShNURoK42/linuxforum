<?php

namespace app\widgets;

class ActiveForm extends \yii\widgets\ActiveForm
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