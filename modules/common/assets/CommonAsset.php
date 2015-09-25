<?php

namespace common\assets;

/**
 * CommonAsset represents a collection of asset files, such as CSS, JS, images.
 */
class CommonAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/assets/source/common';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/common.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/dropdown.js',
        'js/hideSeek.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\NormalizeAsset',
        'common\assets\AwesomeAsset',
    ];
}