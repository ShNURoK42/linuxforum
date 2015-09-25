<?php

namespace sidebar\assets;

class SidebarAsset extends \yii\web\AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@sidebar/assets/source/sidebar';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/sidebar.css',
    ];
}