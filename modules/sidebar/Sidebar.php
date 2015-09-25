<?php
namespace sidebar;

use Yii;
use tag\models\Tag;
use sidebar\assets\SidebarAsset;

class Sidebar extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $view = $this->getView();
        SidebarAsset::register($view);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->render('sidebar');
    }
}