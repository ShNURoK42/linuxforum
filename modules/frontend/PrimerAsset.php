<?php

namespace frontend;

class PrimerAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/primer-css/css';
    /**
     * @inheritdoc
     */
    public $css = [
        'primer.css',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'frontend\PrimerOcticonsAsset',
        'frontend\PrimerMarkdownAsset',
    ];
}