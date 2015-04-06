<?php

namespace app\assets;

/**
 * AppAsset represents a collection of asset files, such as CSS, JS, images.
 */
class MainAsset extends \yii\web\AssetBundle
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
        'css/main/main.css',
        'css/dev.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/common.js',
        'js/post.js',
        'js/postPreview.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\PrimerAsset',
        'app\assets\PrimerOcticonsAsset',
        'app\assets\PrimerMarkdownAsset',
        'app\assets\GoogleAsset',
        'app\assets\SotmarketAsset',

        'app\assets\CaretAsset',
        'app\assets\AtwhoAsset',
    ];
}
