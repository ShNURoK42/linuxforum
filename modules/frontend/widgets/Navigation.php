<?php
namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\widgets\Menu;
use notify\models\UserMention;

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

                $items[] = [
                    'label' => $label . Yii::$app->user->identity->username,
                    'url' => ['/user/default/view', 'id' => Yii::$app->user->id],
                    'options' => [
                        'class' => 'navbar-nav-profile'
                    ]
                ];

                $notifications = UserMention::countByUser($user->id);

                if ($notifications > 0) {
                    $items[] = ['label' => 'Уведомления <span class="counter">' . UserMention::countByUser($user->id) . '</span>', 'url' => ['/notify/default/view']];
                } else {
                    $items[] = ['label' => 'Уведомления', 'url' => ['/notify/default/view']];
                }
            }

            $items[] = ['label' => 'Пользователи', 'url' => ['/user/default/list']];

            if (Yii::$app->user->isGuest) {
                $items[] = ['label' => 'Регистрация', 'url' => ['/user/identity/registration']];
                $items[] = ['label' => 'Вход', 'url' => ['/user/identity/login']];
            } else {
                $items[] = ['label' => 'Выход', 'url' => ['/user/identity/logout']];
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
                ['label' => 'Правила пользования', 'url' => ['/frontend/default/terms']],
                ['label' => '&bull;'],
                ['label' => 'Обратная связь', 'url' => ['/frontend/default/feedback']],
            ];

            return Menu::widget(['encodeLabels' => false, 'items' => $items]);
        }

        return null;
    }
}