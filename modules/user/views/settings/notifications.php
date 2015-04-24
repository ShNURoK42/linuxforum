<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use user\widgets\SettingsMenu;

/* @var \user\models\User $user */
?>
<div class="columns">
    <div class="column one-fourth">
        <?= SettingsMenu::widget() ?>
    </div>
    <div class="column three-fourths profile-box">
        <div class="profile-box-header">Настройки уведомлений</div>
        <div class="profile-box-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '',
            ]) ?>
            <h4>Упоминание вас</h4>
            <p>When you participate in a conversation or someone brings you in with an <a class="user-mention" href="https://github.com/blog/821">@username</a>.</p>
            <ul class="compact-options">
                <li><?= $form->field($model, 'email', ['options' => ['class' => 'form-checkbox']])
                        ->checkbox(['label' => 'По электронной почте']) ?></li>
                <li><?= $form->field($model, 'email', ['options' => ['class' => 'form-checkbox']])
                        ->checkbox(['label' => 'В центре уведомлений']) ?></li>
            </ul>
            <hr class="bleed-flush compact">
            <p><?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-primary']) ?></p>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>