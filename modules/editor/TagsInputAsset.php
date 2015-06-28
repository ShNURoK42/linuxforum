<?php

namespace editor;

class TagsInputAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@editor/assets';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/tags-input.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/tags-input.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\TagsinputAsset',
    ];
}