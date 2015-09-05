<?php

namespace frontend\assets;

class GoogleAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/assets/source/google';
    /**
     * @inheritdoc
     */
    public $js = [
        'js/GoogleAnalytics.js',
    ];
}
