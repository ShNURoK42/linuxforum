<?php

namespace ad;

class AdAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@ad/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/saidnavy.css',
        'css/sotmarket.css',
    ];
}