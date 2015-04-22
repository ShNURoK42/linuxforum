<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;

/* @var \app\components\View $this */
/* @var \user\models\ForgetForm $model */

$this->title = 'Изменение вашего пароля';
?>
<div class="pforget">
    <div class="authbox">
        <div class="authbox-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '',
            ]) ?>
            <?php if (!$model->isCorrectUsername): ?>
            <div class="flash flash-with-icon"><span class="octicon octicon-alert"></span>
                Уважаемый, <strong><?= $model->getUser()->username ?></strong>, ваше имя недопустимо для работы нашего сайта, пожалуйста придумате себе другое имя, используя латинские буквы, цифры, знаки &#171;_&#187; и &#171;-&#187;.
            </div>
            <?= $form->field($model, 'username', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->label('Имя пользователя') ?>
            <hr>
            <?php endif; ?>
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

            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
