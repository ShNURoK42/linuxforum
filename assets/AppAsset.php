<?php

namespace app\assets;

/**
 * AppAsset represents a collection of asset files, such as CSS, JS, images.
 */
class AppAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/Air.css',
        'css/sotmarket.css',
    ];
    public $js = [
        'js/common.js',
        'js/post.js',
    ];
    public $depends = [
        'app\assets\GoogleAssets',
        'yii\web\YiiAsset',
    ];
}
