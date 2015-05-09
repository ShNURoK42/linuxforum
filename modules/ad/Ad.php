<?php
namespace ad;

use Yii;

class Ad extends \yii\base\Widget
{
    public $domen = 'linuxforum.ru';

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->getUser()->getIsGuest() && stristr($_SERVER['HTTP_HOST'], $this->domen)) {
            $view = $this->getView();
            AdAsset::register($view);

            echo $this->render('ad');
        }
    }
}