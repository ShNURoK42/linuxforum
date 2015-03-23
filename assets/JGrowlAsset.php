<?php
namespace app\assets;

use yii\web\AssetBundle;

class JGrowlAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jgrowl';
    /**
     * @inheritdoc
     */
    public $js = [
        'jquery.jgrowl.min.js'
    ];
    /**
     * @inheritdoc
     */
    public $css = [
        'jquery.jgrowl.css',
    ];
}
