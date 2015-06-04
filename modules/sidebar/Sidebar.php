<?php
namespace sidebar;

use Yii;
use tag\models\Tag;

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
        $name = Yii::$app->getRequest()->get('name');

        if ($name !== '') {
            $tagModel = Tag::findOne(['name' => $name]);

            echo $this->render('sidebar', ['tagModel' => $tagModel]);
        } else {
            echo $this->render('sidebar');
        }
    }
}