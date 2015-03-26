<?php

namespace app\assets;

class PrimerAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/primer-css/css';
    /**
     * @inheritdoc
     */
    public $css = [
        'primer.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        //'app\assets\ОcticonsAsset',
    ];
}