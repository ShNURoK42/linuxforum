<?php

namespace frontend;

class PrimerOcticonsAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/octicons/octicons';
    /**
     * @inheritdoc
     */
    public $css = [
        'octicons.css',
    ];
}