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
    public $js = [
        'js/editor.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AtwhoAsset',
        'app\assets\CaretAsset',
        'app\assets\RangyInputsAsset',
        'app\assets\AwesomeAsset',
    ];
}