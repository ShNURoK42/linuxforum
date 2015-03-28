<?php

namespace app\assets;

class PrimerAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';
    /**
     * @inheritdoc
     */
    public $baseUrl = '@web';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/main/primer.css',
    ];
}