<?php

namespace frontend;

class GoogleAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/assets';
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
