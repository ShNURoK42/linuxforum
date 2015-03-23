<?php

namespace app\assets;

/**
 * AppAsset represents a collection of asset files, such as CSS, JS, images.
 */
class AppAsset extends \yii\web\AssetBundle
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
        'css/Air.css',
        'css/sotmarket.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/common.js',
        'js/post.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\GoogleAsset',
        'yii\web\YiiAsset',
    ];
}
