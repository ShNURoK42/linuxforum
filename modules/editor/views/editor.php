<?php
use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;

/* @var \app\components\View $this */
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
    <div class="post-formbox-content clearfix">
        <?php $form = ActiveForm::begin($activeFormOptions) ?>
        <?= $form->errorSummary($model, [
            'header' => '',
        ]) ?>
        <?php if ($titleAttribute):?>
            <?= $form->field($model, $titleAttribute, [
                    'template' => "{input}",
                ])
                    ->textInput([
                    'placeholder' => 'Заголовок темы',
                ])
                    ->label(\Yii::t('app/topic', 'Subject')) ?>
        <?php endif; ?>
        <div class="form-group editor-btn-panel">
            <div class="btn-group">
                <button title="Полужирный текст" class="btn btn-sm js-btn-texticon-bold" type="button"><span class="fa fa-bold"></span></button>
                <button title="Курсивный текст" class="btn btn-sm js-btn-texticon-italic" type="button"><span class="fa fa-italic"></span></button>
                <button title="Зачеркнутый текст" class="btn btn-sm js-btn-texticon-strike" type="button"><span class="fa fa-strikethrough"></span></button>
                <button title="Отступ вправо" class="btn btn-sm js-btn-texticon-indent" type="button"><span class="fa fa-indent"></span></button>
                <button title="Отступ влево" class="btn btn-sm js-btn-texticon-unindent" type="button"><span class="fa fa-outdent"></span></button>
            </div>
            <div class="btn-group">
                <button title="Вставка гиперссылки (URL)" class="btn btn-sm js-btn-texticon-link" type="button"><span class="fa fa-link"></span></button>
                <button title="Вставка картинки" class="btn btn-sm js-btn-texticon-img" type="button"><span class="fa fa-picture-o"></span></button>
            </div>
            <div class="btn-group">
                <button title="Список" class="btn btn-sm js-btn-texticon-bulleted" type="button"><span class="fa fa-list"></span></button>
                <button title="Нумерованный список" class="btn btn-sm js-btn-texticon-numbered" type="button"><span class="fa fa-list-ol"></span></button>
            </div>
            <div class="btn-group">
                <button title="Цитата" class="btn btn-sm js-btn-texticon-quote" type="button"><span class="fa fa-comment"></span></button>
                <button title="Код" class="btn btn-sm js-btn-texticon-blockcode" type="button"><span class="fa fa-code"></span></button>
            </div>
            <div class="right btn-group">
                <button title="Предпросмотр сообщения" class="btn btn-sm js-editor-preview" type="button"><span class="fa fa-eye"></span></button>
            </div>
        </div>
        <?= $form->field($model, $messageAttribute, [
            'template' => "{input}",
        ])
            ->textarea([
                'placeholder' => 'Напишите сообщение',
        ]) ?>
        <div class="form-group editor-preview markdown-body"></div>
        <?php if ($titleAttribute):?>
            <?= $form->field($model, 'tags', [
                'template' => "{label}\n{input}\n{hint}",
            ])
                ->textInput([
                    'placeholder' => 'Добавьте тег',
            ])
                ->label('Теги') ?>
        <?php endif; ?>
        <hr>
        <div class="form-group editor-tips left">
            <span class="fa fa-hand-o-right"></span> При оформлении сообщения Вы можете использовать разметку <strong><a target="_blank" class="muted-link" href="<?= Url::toRoute('/frontend/default/markdown') ?>">markdown</a></strong>.<br />
            <span class="fa fa-hand-o-right"></span> Для обращения к участнику дискуссии текущей темы введите <strong>@</strong> и выберите пользователя.
        </div>
        <div class="form-actions right">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
