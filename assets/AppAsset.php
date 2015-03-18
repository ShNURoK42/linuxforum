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
    ];
    public $js = [
        //'js/app.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
    ];
}
