<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Welcome
 */
class Welcome extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $content = '';

        if (Yii::$app->getUser()->getIsGuest()) {
            $content .= Html::tag('p', Yii::t('app/common', 'Not logged in'), ['class' => 'conl']);

            $items[] = Yii::t('app/common', 'Topics') . Html::a(Yii::t('app/common', 'Active topics'), Url::to(['site/search']), ['title' => Yii::t('app/common', 'Show active topics')]);
            $items[] = '|';
            $items[] = Html::a(Yii::t('app/common', 'Unanswered topics'), Url::to('/'), ['title' => Yii::t('app/common', 'Show unanswered topics')]);
            $content .= Html::ul($items, ['class' => 'conr', 'encode' => false]);

            $content .= Html::tag('div', '', ['class' => 'clearer']);
        } else {
            $content .= Html::tag('p', 'Вы вошли как: ' . Yii::$app->getUser()->getIdentity()->username, ['class' => 'conl']);
            $content .= Html::tag('p', Html::a('Активные темы', Url::toRoute('search/view-active-topics')), ['class' => 'conr']);

            $content .= Html::tag('div', '', ['class' => 'clearer']);
        }

        return Html::tag('div', $content, ['id' => 'brdwelcome', 'class' => 'inbox']);
    }
}