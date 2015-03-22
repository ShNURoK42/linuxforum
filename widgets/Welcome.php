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
            $content .= Html::tag('p', Html::a('Активные темы', Url::toRoute('search/view-active-topics')), ['class' => 'conr']);
            $content .= Html::tag('div', '', ['class' => 'clearer']);
        } else {
            $content .= Html::tag('p', 'Вы вошли как: ' . Yii::$app->getUser()->getIdentity()->username, ['class' => 'conl']);
            $content .= Html::tag('p', Html::a('Активные темы', Url::toRoute('search/view-active-topics')), ['class' => 'conr']);
            $content .= Html::tag('div', '', ['class' => 'clearer']);
        }

        return Html::tag('div', $content, ['id' => 'brdwelcome', 'class' => 'inbox']);
    }
}