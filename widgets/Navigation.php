<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

use yii\widgets\Menu;

class Navigation extends Widget
{
    public $position;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (strtolower($this->position) == 'header') {
            if (!Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;

                $label = \cebe\gravatar\Gravatar::widget([
                    'email' => $user->email,
                    'options' => [
                        'alt' => '',
                        'class' => 'avatar',
                        'width' => 20,
                        'height' => 20,
                    ],
                    'defaultImage' => 'retro',
                    'size' => 20
                ]);

                $items[] = ['label' => $label . Yii::$app->user->identity->username, 'url' => ['user/view', 'id' => Yii::$app->user->id]];
            }

            $items[] = ['label' => 'Пользователи', 'url' => ['user/list']];

            if (Yii::$app->user->isGuest) {
                $items[] = ['label' => 'Регистрация', 'url' => ['user/registration']];
                $items[] = ['label' => 'Вход', 'url' => ['user/login']];
            } else {
                $items[] = ['label' => 'Выход', 'url' => ['user/logout']];
            }

            return Menu::widget([
                'items' => $items,
                'encodeLabels' => false,
                'options' => [
                    'class' => 'navbar-nav'
                ]
            ]);
        } elseif (strtolower($this->position) == 'footer') {
            $items = [
                //['label' => 'О сайте', 'url' => ['site/about']],
                //['label' => '&bull;'],
                ['label' => 'Правила пользования', 'url' => ['site/terms']],
                //['label' => '&bull;'],
                //['label' => 'Обратная связь', 'url' => ['site/contact']],
            ];

            return Menu::widget(['encodeLabels' => false, 'items' => $items]);
        }

        return null;
    }
}