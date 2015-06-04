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
            if (!Yii::$app->user->isGuest) {
                $user = Yii::$app->user->identity;

                $avatar = \cebe\gravatar\Gravatar::widget([
                    'email' => $user->email,
                    'options' => [
                        'alt' => '',
                        'class' => 'avatar',
                        'width' => 24,
                        'height' => 24,
                    ],
                    'defaultImage' => 'retro',
                    'size' => 24
                ]);

                $items[] = [
                    'label' => $avatar . Yii::$app->user->identity->username,
                    'url' => ['/user/default/view', 'id' => Yii::$app->user->id],
                    'options' => [
                        'class' => 'navbar-nav-profile'
                    ]
                ];
            }


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
        } elseif(strtolower($this->position) == 'sub_header') {
            $items[] = ['label' => 'Последние темы', 'url' => ['/topic/default/list']];


            if (!Yii::$app->getUser()->getIsGuest()) {
                $id = Yii::$app->getUser()->getIdentity()->id;
                $notifications = UserMention::countByUser($id);

                if ($notifications > 0) {
                    $items[] = ['label' => 'Уведомления <span class="counter">' . $notifications . '</span>', 'url' => ['/notify/default/view']];
                } else {
                    $items[] = ['label' => 'Уведомления', 'url' => ['/notify/default/view']];
                }
            }

            $items[] = ['label' => 'Пользователи', 'url' => ['/user/default/list']];

            if (!Yii::$app->getUser()->getIsGuest()) {
                $items[] = ['label' => 'Создать тему', 'url' => ['/topic/default/create']];
            }


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