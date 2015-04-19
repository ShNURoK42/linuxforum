<?php
namespace app\widgets;

use Yii;

class AdBlock extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            echo $this->render('adBlock');
        }
    }
}