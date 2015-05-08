<?php

namespace forum;

class ForumAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AwesomeAsset',
    ];
}