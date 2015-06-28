<?php

namespace post;

class PostAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@post/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/post.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/post.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AwesomeAsset',
    ];
}