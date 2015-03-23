<?php

namespace app\assets;

class GoogleAsset extends \yii\web\AssetBundle
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
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/GoogleAnalytics.js',
    ];
}
