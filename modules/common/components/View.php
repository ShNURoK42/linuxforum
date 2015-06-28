<?php

namespace common\components;

use Yii;
use yii\data\DataProviderInterface;
use yii\data\Pagination;

/**
 * Class View
 */
class View extends \yii\web\View
{
    /**
     * @var string the page subtitle.
     */
    public $subtitle;
    /**
     * @var string the page description.
     */
    public $description;
    /**
     * @var string the page keywords.
     */
    public $keywords;
    /**
     * @var string the page author
     */
    public $author;

    /**
     * @inheritdoc
     */
    public function afterRender($viewFile, $params, &$output)
    {
        parent::afterRender($viewFile, $params, $output);

        if (isset($params['dataProvider']) && $params['dataProvider'] instanceof DataProviderInterface && $params['dataProvider']->pagination instanceof Pagination) {
            $this->title .= $this->getPage($params['dataProvider']->pagination);
        }
    }

    /**
     * @param Pagination $pagination
     * @return string
     */
    protected function getPage(Pagination $pagination)
    {
        $page = $pagination->getPage() + 1;

        if ($page == 1) {
            return '';
        }

        return ' (' . Yii::t('app/common', 'Page number', ['page' => $page]) . ')';
    }
}