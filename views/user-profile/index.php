<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;

/* @var \app\models\User $user */
?>
<div class="columns">
    <div class="column one-fourth">
        <nav data-pjax="" class="menu">
            <h3 class="menu-heading">Персональные настройки</h3>
            <a data-selected-links="avatar_settings /settings/profile" class="selected js-selected-navigation-item menu-item" href="/settings/profile">Основные</a>
        </nav>
    </div>
    <div class="column three-fourths profile-box">
        <div class="profile-box-header">Основные настройки профиля</div>
        <div class="profile-box-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '',
            ]) ?>
            <?= $form->field($model, 'message', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])->textarea([
                'placeholder' => 'Напишите коротко о себе',
            ])->label('Информация о себе') ?>
            <p><?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?></p>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>