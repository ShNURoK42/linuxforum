<?php

namespace common\widgets;

use Yii;

class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @inheritdoc
     */
    public $maxButtonCount = 10;
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
}