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

$bundle = \editor\EditorAsset::register($this);
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
                ])->textInput([
                    'placeholder' => 'Заголовок темы',
                ])
                ->label(\Yii::t('app/topic', 'Subject')) ?>
        <?php endif; ?>
        <div class="editor-btn-panel">
            <div class="btn-group">
                <button title="Полужирный текст" class="btn btn-sm btn-outline js-btn-texticon-bold" type="button"><span class="glyphicon glyphicon-bold"></span></button>
                <button title="Курсивный текст" class="btn btn-sm btn-outline js-btn-texticon-italic" type="button"><span class="glyphicon glyphicon-italic"></span></button>
                <button title="Новый абзац" class="btn btn-sm btn-outline js-btn-texticon-paragraph" type="button"><span class="glyphicon glyphicon-font"></span></button>
                <button title="Перевод на новую строку" class="btn btn-sm btn-outline js-btn-texticon-newline" type="button"><span class="glyphicon glyphicon-text-height"></span></button>
            </div>
            <div class="btn-group">
                <button title="Вставка гиперссылки (URL)" class="btn btn-sm btn-outline js-btn-texticon-link" type="button"><span class="glyphicon glyphicon-link"></span></button>
                <button title="Вставка картинки" class="btn btn-sm btn-outline js-btn-texticon-img" type="button"><span class="glyphicon glyphicon-picture"></span></button>
            </div>
            <div class="btn-group">
                <button title="Отступ вправо" class="btn btn-sm btn-outline js-btn-texticon-indent" type="button"><span class="glyphicon glyphicon-indent-left"></span></button>
                <button title="Отступ влево" class="btn btn-sm btn-outline js-btn-texticon-unindent" type="button"><span class="glyphicon glyphicon-indent-right"></span></button>
            </div>
            <div class="btn-group">
                <button title="Список" class="btn btn-sm btn-outline js-btn-texticon-bulleted" type="button"><spani class="glyphicon glyphicon-list"></spani></button>
                <button title="Нумерованный список" class="btn btn-sm btn-outline js-btn-texticon-numbered" type="button"><span class="glyphicon glyphicon-list-alt"></span></button>
            </div>
            <div class="btn-group">
                <button title="Цитата" class="btn btn-sm btn-outline js-btn-texticon-quote" type="button"><span class="glyphicon glyphicon-comment"></span></button>
            </div>
            <div class="btn-group">
                <button title="Строковый код" class="btn btn-sm btn-outline js-btn-texticon-inlinecode" type="button"><span class="glyphicon glyphicon-expand"></span></button>
                <button title="Блочный код" class="btn btn-sm btn-outline js-btn-texticon-blockcode" type="button"><span class="glyphicon glyphicon-collapse-down"></span></button>
            </div>
            <div class="right btn-group">
                <button title="Предпросмотр сообщения" class="btn btn-sm btn-outline js-editor-preview" type="button"><span class="glyphicon glyphicon-search"></span></button>
            </div>
        </div>
        <?= $form->field($model, $messageAttribute, [
            'template' => "{input}",
        ])->textarea([
            'placeholder' => 'Напишите сообщение',
        ]) ?>
        <div class="editor-preview markdown-body"></div>
        <div class="editor-tips left">
            <span class="glyphicon glyphicon-arrow-right"></span> При оформлении сообщения Вы можете использовать разметку <strong><a target="_blank" class="muted-link" href="/markdown">markdown</a></strong><br />
            <span class="glyphicon glyphicon-arrow-right"></span> Для обращения к участнику дискуссии текущей темы введите <strong>@</strong> и выбирите пользователя.
        </div>
        <div class="form-actions right">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
