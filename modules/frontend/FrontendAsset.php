<?php

namespace frontend;

/**
 * AppAsset represents a collection of asset files, such as CSS, JS, images.
 */
class FrontendAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/main.css',
        'css/dev.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\PrimerAsset',
    ];
}
