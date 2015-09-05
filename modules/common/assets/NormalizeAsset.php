<?php

namespace common\assets;

class NormalizeAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/normalize.css';
    /**
     * @inheritdoc
     */
    public $css = [
        'normalize.css',
    ];
    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'only' => [
            'normalize.css',
        ]
    ];
}