<?php

namespace editor;

class TextareaAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@editor/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/editor.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/textarea.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\FrontendAsset',
        'common\assets\AtwhoAsset',
    ];
}