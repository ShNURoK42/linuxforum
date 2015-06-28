<?php

/* @var \common\components\View $this */
/* @var RegistrationForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use captcha\widgets\Captcha;
use user\models\RegistrationForm;

$this->title = 'Регистрация в сообществе';
$this->subtitle = 'Присоединяйтесь к нам прямо сейчас!';
$this->params['page'] = 'register';
?>
<div class="pregistration">
    <div class="authbox">
        <div class="authbox-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '',
            ]) ?>
            <?= $form->field($model, 'email', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->label('Электронная почта') ?>
            <?= $form->field($model, 'username', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->label('Ваше имя') ?>
            <?= $form->field($model, 'password', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->passwordInput()
                ->label('Пароль') ?>
            <?= $form->field($model, 'repassword', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->passwordInput()
                ->label('Пароль повторно') ?>
            <?= $form->field($model, 'termsAgree', ['options' => ['class' => 'form-checkbox']])
                ->checkbox(['label' => 'Я согласен с <a href="' . Url::toRoute('/frontend/default/terms') . '">правилами пользования</a> сайта.']) ?>
            <?php if ($model->isShow): ?>
                <?= $form->field($model, 'verifyCode', [
                    'options' => [
                        'tag' => 'dl',
                        'class' => 'form',
                    ],
                    'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
                ])
                    ->widget(Captcha::className())
                    ->label('Код безопасности') ?>
            <?php endif; ?>
            <?= Html::submitButton('Регистрация в сообществе', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="authbox-footer">
            <p>Вы уже зарегистрированы у нас? <a href="<?= Url::toRoute('/user/identity/login') ?>">Пожалуйста авторизуйтесь.</a></p>
            <p>Не получается вспомнить пароль? <a href="<?= Url::toRoute('/user/forget/index') ?>">Вы можете его сменить.</a></p>
        </div>
    </div>
</div>