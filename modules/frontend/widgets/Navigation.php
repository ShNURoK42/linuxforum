<?php
namespace frontend\widgets;

use Yii;
use yii\widgets\Menu;
use notify\models\UserMention;

class Navigation extends \yii\base\Widget
{
    public $position;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (strtolower($this->position) == 'header') {
            $items[] = ['label' => '<i class="fa fa-wrench"></i> Настройки', 'url' => ['/user/identity/registration']];
            $items[] = ['label' => '<i class="fa fa-bell"></i> Уведомления (1)', 'url' => ['/user/identity/registration'], 'options' => ['class' => 'new']];
            $items[] = ['label' => '<i class="fa fa-envelope"></i> Сообщения (3)', 'url' => ['/user/identity/registration']];
            $items[] = ['label' => '<i class="fa fa-users"></i> Пользователи', 'url' => ['/user/identity/registration']];
            $items[] = ['label' => '<i class="fa fa-question-circle"></i> Помощь', 'url' => ['/user/identity/registration']];


            return Menu::widget([
                'items' => $items,
                'encodeLabels' => false,
                'options' => [
                    'class' => 'navbar-nav'
                ]
            ]);
        } elseif(strtolower($this->position) == 'sub_header') {
            $items[] = ['label' => 'Лента', 'url' => ['/user/default/list5']];
            $items[] = ['label' => 'Страницы', 'url' => ['/user/default/list5']];
            $items[] = ['label' => 'Вопросы', 'url' => ['/topic/default/list1']];
            $items[] = ['label' => 'Статьи', 'url' => ['/topic/default/list3']];
            $items[] = ['label' => 'Обсуждения', 'url' => ['/topic/default/list4']];

            return Menu::widget([
                'items' => $items,
                'encodeLabels' => false,
                'options' => [
                    'class' => 'sub-navbar-nav'
                ]
            ]);
        } elseif (strtolower($this->position) == 'footer') {
            $items = [
                ['label' => 'Правила пользования', 'url' => ['/frontend/default/terms']],
                ['label' => '&bull;'],
                ['label' => 'Обратная связь', 'url' => ['/frontend/default/feedback']],
            ];

            return Menu::widget(['encodeLabels' => false, 'items' => $items]);


        }

        return null;
    }
}
