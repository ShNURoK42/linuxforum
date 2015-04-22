<?php
namespace ad;

use Yii;

class Ad extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            $view = $this->getView();
            AdAsset::register($view);

            echo $this->render('ad');
        }
    }
}