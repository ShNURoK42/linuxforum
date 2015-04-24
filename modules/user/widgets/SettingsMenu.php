<?php
namespace user\widgets;

use Yii;
use yii\widgets\Menu;

class SettingsMenu extends \yii\base\Widget
{
    public $position;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $items = [
            ['label' => 'Основные', 'url' => ['/user/settings/profile']],
            ['label' => 'Уведомления', 'url' => ['/user/settings/notifications']],
        ];


        echo '<nav class="menu">';
        echo '<h3 class="menu-heading">Разделы настроек</h3>';
        echo Menu::widget([
            'items' => $items,
            'itemOptions' => [
                'class' => 'menu-item',
            ],
            'activeCssClass' => 'selected',
        ]);
        echo "</nav>";
    }
}