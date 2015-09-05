<?php

namespace common\assets;

/**
 * AppAsset represents a collection of asset files, such as CSS, JS, images.
 */
class AppAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/assets/source/app';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/app.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'common\assets\NormalizeAsset',
    ];
}