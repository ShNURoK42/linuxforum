<?php

namespace common\assets;

class TagsinputAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/bootstrap-tagsinput/dist';
    /**
     * @inheritdoc
     */
    public $js = [
        'bootstrap-tagsinput.min.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'common\assets\TypeaheadAsset',
    ];
}