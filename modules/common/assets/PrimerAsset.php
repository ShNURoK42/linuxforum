<?php

namespace common\assets;

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
        'common\assets\PrimerMarkdownAsset',
    ];
}