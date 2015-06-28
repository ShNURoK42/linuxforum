<?php

namespace common\assets;

class AwesomeAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/fontawesome';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.min.css',
    ];
}