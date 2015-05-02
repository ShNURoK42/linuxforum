<?php

namespace editor;

class RangyInputsAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/rangyinputs';
    /**
     * @inheritdoc
     */
    public $js = [
        'rangyinputs-jquery.js',
    ];
}