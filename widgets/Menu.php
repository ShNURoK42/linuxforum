<?php
namespace app\widgets;

use Yii;
use app\helpers\AccessHelper;
use yii\helpers\Html;

/**
 * Class Menu
 */
class Menu extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $links = [
            'index' => ['label' => Yii::t('app/common', 'Index'), 'url' => ['site/index'], 'options' => ['id' => 'navindex']],
            'userlist' => ['label' => Yii::t('app/common', 'User list'), 'url' => ['user/list'], 'options' => ['id' => 'navuserlist']],
            'rules' => ['label' => Yii::t('app/common', 'Rules'), 'url' => ['site/rules'], 'options' => ['id' => 'navrules']],
            'search' => ['label' => Yii::t('app/common', 'Search'), 'url' => ['site/search'], 'options' => ['id' => 'navsearch']],
            'register' => ['label' => Yii::t('app/common', 'Register'), 'url' => ['user/register'], 'options' => ['id' => 'navregister']],
            'login' => ['label' => Yii::t('app/common', 'Login'), 'url' => ['user/login'], 'options' => ['id' => 'navlogin']],
            'logout' => ['label' => Yii::t('app/common', 'Logout'), 'url' => ['user/logout'], 'options' => ['id' => 'navlogout']],
            'profile' => ['label' => Yii::t('app/common', 'Profile'), 'url' => ['user/view', 'id' => Yii::$app->user->id], 'options' => ['id' => 'navprofile']],
            //'admin' => ['label' => Yii::t('app/common', 'Administration'), 'url' => ['admin-index/index'], 'options' => ['id' => 'navadmin']],
        ];

        $items[] = $links['index'];
        if (AccessHelper::can('read_board') && AccessHelper::can('view_users')) {
            $items[] = $links['userlist'];
        }
        if (Yii::$app->config->get('o_rules') == '1' && (!Yii::$app->user->isGuest || AccessHelper::can('g_read_board') || Yii::$app->config->get('o_regs_allow') == '1')) {
            $items[] = $links['rules'];
        }
        if (Yii::$app->user->isGuest) {
            if (AccessHelper::can('read_board') && AccessHelper::can('search')) {
                $items[] = $links['search'];
            }
            $items[] = $links['register'];
            $items[] = $links['login'];
        } else {
            $items[] = $links['profile'];
            if (AccessHelper::isAdmMod()) {
                $items[] = $links['search'];
                //$items[] = $links['admin'];
            } elseif (AccessHelper::can('read_board') && AccessHelper::can('search')) {
                $items[] = $links['search'];
            }
            $items[] = $links['logout'];
        }

        $menu = \yii\widgets\Menu::widget([
            'activeCssClass' => 'isactive',
            'items' => $items,
        ]);

        echo Html::tag('div', $menu, ['id' => 'brdmenu', 'class' => 'inbox']);
    }
}