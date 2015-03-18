<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Topic;

/**
 * Class TopicPager
 */
class TopicPager extends \yii\base\Widget
{
    /**
     * @var Topic $topic
     */
    public $topic;
    /**
     * @var integer the default page size.
     */
    public $defaultPageSize;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->defaultPageSize) {
            $this->defaultPageSize = Yii::$app->config->get('o_disp_posts_default');
        }

        if ($this->topic->num_replies <= $this->defaultPageSize) {
            return;
        }

        $pageCount = ceil($this->topic->num_replies / $this->defaultPageSize);
        $items[] = Html::a('1', $this->generateLink());

        if ($pageCount > 5) {
            for ($i = 2; $i <= 3; $i++) {
                $items[] = Html::a($i, $this->generateLink($i));
            }
            $items[] = '...';
            $items[] = Html::a($pageCount, $this->generateLink($pageCount));
        } else {
            for ($i = 2; $i <= $pageCount; $i++) {
                $items[] = Html::a($i, $this->generateLink($i));
            }
        }

        echo Html::tag('span', '[ ' . implode(' ', $items) . ' ]', ['class' => 'pagestext']);
    }

    /**
     * Create a URL for the topic page with specified identificator.
     * @param string $page page identificator
     * @return string
     */
    protected function generateLink($page = null)
    {
        if ($page) {
            return Url::toRoute(['topic/view', 'id' => $this->topic->id, 'page' => $page]);
        } else {
            return Url::toRoute(['topic/view', 'id' => $this->topic->id]);
        }
    }
}