<?php

namespace app\assets;

class PrimerAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/primer-css';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/primer.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\PrimerMarkdownAsset',
    ];
}