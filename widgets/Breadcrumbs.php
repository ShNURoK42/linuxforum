<?php
namespace app\widgets;

use Yii;
use yii\helpers\Url;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /**
     * @inheritdoc
     */
    public $options = ['class' => 'crumbs'];
    /**
     * @inheritdoc
     */
    public $itemTemplate = "<li>{link}</li><li>&#187;</li>";

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->homeLink = [
            'label' => Yii::$app->config->get('o_board_title'),
            'url' => Url::home(),
        ];

        if (isset($this->getView()->params['breadcrumbs'])) {
            $this->links = $this->getView()->params['breadcrumbs'];
        } else {
            $this->links = [];
        }
    }
}
