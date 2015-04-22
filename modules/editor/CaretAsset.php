<?php

namespace editor;

class CaretAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/caret.js/dist';
    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.caret.js',
    ];
}