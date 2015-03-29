<?php

namespace app\widgets;

class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @inheritdoc
     */
    public $template = "{label}\n{input}\n{hint}";
}