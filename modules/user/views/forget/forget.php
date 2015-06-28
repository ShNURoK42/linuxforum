<?php

/* @var \common\components\View $this */
/* @var \user\models\ForgetForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use captcha\widgets\Captcha;

$this->title = 'Изменение вашего пароля';
?>
<div class="pforget">
    <div class="authbox">
        <div class="authbox-header">
            <p>Мы поможем изменить вам пароль, но вы должны ввести адрес вашей электронной почты, к которой привязан аккаунт.</p>
            <p>На эту электронную почту мы вышлем вам дальнейшую инструкцию.</p>
        </div>
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
            <?= Html::submitButton('Восстановить пароль', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="authbox-footer">
            <p>Нет учетной записи? <a href="<?= Url::toRoute('/user/identity/registration') ?>">Присоединяйтесь к нам прямо сейчас!</a></p>
            <p>Вы уже зарегистрированы у нас? <a href="<?= Url::toRoute('/user/identity/login') ?>">Пожалуйста авторизуйтесь.</a></p>
        </div>
    </div>
</div>
