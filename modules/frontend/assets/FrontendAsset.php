<?php

namespace frontend\assets;

class FrontendAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/assets/source/frontend';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/frontend.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/frontend.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'common\assets\CommonAsset',
    ];
}