<?php

namespace topic;

class TopicAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@topic/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/topic.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/topic.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AppAsset',
        'common\assets\AwesomeAsset',
    ];
}