<?php

namespace common\assets;

class TypeaheadAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/typeahead.js/dist';
    /**
     * @inheritdoc
     */
    public $js = [
        'typeahead.bundle.min.js',
    ];
}