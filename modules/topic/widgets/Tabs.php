<?php
namespace topic\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class Tabs extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $sortBy = Yii::$app->request->get('sort_by', 'new');

        $items = [
            ['label' => 'Новые', 'url' => Url::current(['sort_by' => 'new']), 'active' => ($sortBy == 'new'), 'options' => [
                'title' => 'Темы отсортированные по времени последнего сообщения',
            ]],
            ['label' => 'Без ответов', 'url' => Url::current(['sort_by' => 'unanwser']), 'active' => ($sortBy == 'unanwser'), 'options' => [
                'title' => 'Темы отсортированные по времени последнего сообщения и не содержащие ответов',
            ]],
            ['label' => 'Ваши', 'url' => Url::current(['sort_by' => 'own']), 'active' => ($sortBy == 'own'), 'options' => [
                'title' => 'Темы отсортированные по времени последнего сообщения и не содержащие ответов',
            ]],
        ];

        return Menu::widget([
            'items' => $items,
            'options' => [
                'class' => 'question-list-tabs'
            ]
        ]);
    }
}