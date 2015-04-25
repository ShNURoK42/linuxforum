<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
            <h4>Упоминание вас в сообщениях</h4>
            <p>Способ информирования, когда кто-то упоминает вас в сообщении, как <a class="user-mention" href="<?= Url::toRoute(['/user/default/view', 'id' => $user->id]) ?>">@<?= $user->username ?></a></p>
            <ul class="compact-options">
                <li><?= $form->field($model, 'notify_mention_email', ['options' => ['class' => 'form-checkbox']])
                        ->checkbox(['label' => 'По электронной почте']) ?></li>
                <li><?= $form->field($model, 'notify_mention_web', ['options' => ['class' => 'form-checkbox']])
                        ->checkbox(['label' => 'В центре уведомлений']) ?></li>
            </ul>
            <hr class="bleed-flush compact">
            <p><?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-primary']) ?></p>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>