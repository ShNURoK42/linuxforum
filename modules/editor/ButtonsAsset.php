<?php

namespace editor;

class ButtonsAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@editor/assets';
    /**
     * @inheritdoc
     */
    public $js = [
        'js/buttons.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'editor\TextareaAsset',
        'common\assets\RangyInputsAsset',
        'common\assets\AwesomeAsset',
    ];
}