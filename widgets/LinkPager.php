<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Class LinkPager
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @inheritdoc
     */
    public $maxButtonCount = 10;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->nextPageLabel = 'Далее';
        $this->prevPageLabel = 'Назад';
    }
}