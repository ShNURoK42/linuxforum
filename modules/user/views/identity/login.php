<?php

/* @var \common\components\View $this */
/* @var \user\models\LoginForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use captcha\widgets\Captcha;

$this->title = 'Вход в сообщество';
?>
<div class="plogin">
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
            <?= $form->field($model, 'password', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->passwordInput()
                ->label('Пароль') ?>
            <?= $form->field($model, 'remember', ['options' => ['class' => 'form-checkbox']])
                ->checkbox(['label' => 'Запомнить меня на этом компьютере?']) ?>
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
            <?= Html::submitButton('Войти в сообщество', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="authbox-footer">
            <p>Нет учетной записи? <a href="<?= Url::toRoute('/user/identity/registration') ?>">Присоединяйтесь к нам прямо сейчас!</a></p>
            <p>Не получается вспомнить пароль? <a href="<?= Url::toRoute('/user/forget/index') ?>">Вы можете его сменить.</a></p>
        </div>
    </div>
</div>

