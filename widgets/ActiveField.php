<?php

namespace app\widgets;

use yii\widgets\ActiveField as YiiActiveField;

class ActiveField extends YiiActiveField
{
    /**
     * @inheritdoc
     */
    public $template = "{label}\n{input}\n{hint}";
}