<?php

namespace app\assets;

class GoogleAssets extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $js = [
        'js/GoogleAnalytics.js',
    ];
}
