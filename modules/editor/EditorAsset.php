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
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'editor\AtwhoAsset',
        'editor\CaretAsset',
    ];
}