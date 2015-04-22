<?php
use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;

/* @var \user\models\User $user */
/* @var \post\models\PostForm $model */
/* @var string $titleAttribute */
/* @var string $messageAttribute */
/* @var array $activeFormOptions */
?>

<div class="post-formbox">
    <div class="post-avatar">
        <?php if ($user->email): ?>
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
    <div class="post-formbox-content">
        <?php $form = ActiveForm::begin($activeFormOptions) ?>
        <?= $form->errorSummary($model, [
            'header' => '',
        ]) ?>
        <?php if ($titleAttribute):?>
            <?= $form->field($model, $titleAttribute, [
            'template' => "{input}",
                ])->textInput([
                    'placeholder' => 'Заголовок темы',
                ])
                ->label(\Yii::t('app/topic', 'Subject')) ?>
        <?php endif; ?>
        <div class="tabnav post-formbox-tabnav">
            <div class="right">
                <a class="tabnav-extra" target="_blank" href="<?= Url::toRoute('/frontend/default/markdown') ?>"><span class="octicon octicon-markdown"></span>Поддержка markdown</a>
            </div>
            <nav class="tabnav-tabs">
                <a href="#" class="tabnav-tab js-post-write-tab selected">Набор сообщения</a>
                <a href="#" class="tabnav-tab js-post-preview-tab">Предпросмотр</a>
            </nav>
        </div>
        <?= $form->field($model, $messageAttribute, [
            'template' => "{input}",
        ])->textarea([
            'placeholder' => 'Напишите сообщение',
        ]) ?>
        <div class="post-formbox-preview markdown-body"></div>
        <div class="form-actions">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
