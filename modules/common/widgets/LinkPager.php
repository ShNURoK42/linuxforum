<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @inheritdoc
     */
    public $maxButtonCount = 5;
    /**
     * @inheritdoc
     */
    public $firstPageLabel = 'Первая';
    /**
     * @inheritdoc
     */
    public $lastPageLabel = 'Последняя';
    /**
     * @inheritdoc
     */
    public $nextPageLabel = false;
    /**
     * @inheritdoc
     */
    public $prevPageLabel = false;
    /**
     * @inheritdoc
     */
    public $firstPageCssClass = 'pagination__item-first';
    /**
     * @inheritdoc
     */
    public $lastPageCssClass = 'pagination__item-last';
    /**
     * @inheritdoc
     */
    public $activePageCssClass = 'pagination__link-active';
    /**
     * @inheritdoc
     */
    public $disabledPageCssClass = 'pagination__link-disabled';
    /**
     * @inheritdoc
     */
    public $linkOptions = ['class' => 'pagination__link'];
    /**
     * @var string the CSS class for the each page button.
     */
    public $pageCssClass = 'pagination__item';

    /**
     * @inheritdoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        $options['class'] = $this->pageCssClass;
        Html::addCssClass($options, $class);

        if ($active) {
            Html::addCssClass($linkOptions, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($linkOptions, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label, $linkOptions), $options);
        }

        return Html::tag('li', Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}