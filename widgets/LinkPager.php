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

        if ($this->pagination->page + 1 == $this->pagination->pageCount) {
            $this->nextPageLabel = null;
        }

        if ($this->pagination->page == 0) {
            $this->prevPageLabel = null;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }

        if ($this->pagination->pageCount < 2) {
            echo Html::tag('span', 'Страницы:', ['class' => 'pages-label']) . Html::tag('strong', 1, ['class' => 'item']);
        } else {
            echo Html::tag('span', 'Страницы:', ['class' => 'pages-label']) . $this->renderPageButtons();
        }
    }
}