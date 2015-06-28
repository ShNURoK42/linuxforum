<?php
/* @var \common\components\View $this */
/* @var \user\models\User $user */
/* @var \post\models\CreateForm $model */

use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$user = Yii::$app->getUser()->getIdentity();
?>
<div class="editorbox js-editor">
    <div class="editor-avatar">
        <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
            <a href="<?= Url::toRoute(['/user/default/view', 'id' => $user->id])?>"><?= Gravatar::widget([
                    'email' => $user->email,
                    'options' => [
                        'alt' => $user->username,
                        'class' => 'avatar',
                        'width' => 48,
                        'height' => 48,
                    ],
                    'defaultImage' => 'retro',
                    'size' => 48
                ]); ?></a>
        <?php endif; ?>
    </div>
    <div class="editor-formbox">
        <?php $form = ActiveForm::begin([
            'enableClientScript' => false,
        ]) ?>
        <?= $form->errorSummary($model, [
            'class' => 'form-group',
            'header' => '',
        ]) ?>
        <?= $form->field($model, 'message', [
            'template' => "{input}",
        ])->widget('\editor\widgets\Textarea')
        ?>
        <div class="form-group editor-footer">
            <div class="editor-tips">
                <span class="fa fa-hand-o-right"></span> При оформлении сообщения Вы можете использовать разметку <strong><a target="_blank" class="muted-link" href="<?= Url::toRoute('/frontend/default/markdown') ?>">markdown</a></strong>.<br />
                <span class="fa fa-hand-o-right"></span> Для обращения к участнику дискуссии введите <strong>@</strong> и выберите пользователя.
            </div>
            <div class="editor-actions">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary js-topic-create-submit']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>