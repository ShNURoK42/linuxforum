<?php

namespace captcha\widgets;

use Yii;
use yii\captcha\Captcha as YiiCaptcha;
use yii\helpers\Html;

class Captcha extends \yii\widgets\InputWidget
{
    public function run()
    {
        $this->getView()->registerJs("
            $('#verifycode-hint').on('click', function(){
                $('#verifycode-image').trigger('click');
            });
        ");

        return YiiCaptcha::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'captchaAction' => '/captcha/default/index',
            'template' => '{input}{image}' . $this->renderReloader(),
            'options' => [
                'class' => 'form-control',
            ],
            'imageOptions' => [
                'id' => 'verifycode-image',
                'alt' => 'Код безопасности',
                'class' => 'captcha-image',
            ],
        ]);
    }

    protected function renderReloader()
    {
        $text = Html::tag('p', 'На изображении плохо видно буквы?');
        $link = Html::tag('p', 'Нажмите сюда для обновления.', ['id' => 'verifycode-hint', 'class' => 'captcha-hint-link']);

        Html::addCssClass($options, 'captcha-hint');
        return Html::tag('div', $text . $link, $options);
    }
}
