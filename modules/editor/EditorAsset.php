<?php

namespace editor;

class EditorAsset extends \yii\web\AssetBundle
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
        'js/editor.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\FrontendAsset',
        'app\assets\AtwhoAsset',
        'app\assets\RangyInputsAsset',
        'app\assets\AwesomeAsset',

        'app\assets\TagsinputAsset',
    ];
}