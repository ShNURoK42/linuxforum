<?php

namespace forum;

class ForumAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@forum/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/forum.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'app\assets\AwesomeAsset',
    ];
}