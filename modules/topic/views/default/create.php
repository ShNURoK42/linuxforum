<?php

/** @var \common\components\View $this */
/** @var \topic\models\CreateForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use sidebar\Sidebar;

$this->title = 'Создание новой темы на форуме';
?>
<div class="p-topic-create">
    <div class="tc-header">
        <h1><?= $formatter->asText($this->title) ?></h1>
    </div>
    <div class="tc-content">
        <div class="tc-editorbox js-editor">
            <div class="tc-editor-formbox">
                <?php $form = ActiveForm::begin([]) ?>
                <?= $form->errorSummary($model, [
                    'class' => 'form-group',
                    'header' => '',
                ]) ?>
                <?= $form->field($model, 'subject', [
                    'template' => "{input}",
                ])
                    ->textInput([
                        'placeholder' => 'Заголовок темы',
                    ])
                    ->label(\Yii::t('app/topic', 'Subject')) ?>
                <?= $form->field($model, 'message', [
                    'template' => "{input}",
                ])->widget('\editor\widgets\Textarea')
                ?>
                <?= $form->field($model, 'tags', [
                    'template' => "{label}\n{input}",
                ])->widget('\editor\widgets\TagsInput')
                ->label('Список меток')
                ?>
                <div class="form-group editor-footer">
                    <div class="editor-tips">
                        <span class="fa fa-hand-o-right"></span> При оформлении сообщения Вы можете использовать разметку <strong><a target="_blank" class="muted-link" href="<?= Url::toRoute('/frontend/default/markdown') ?>">markdown</a></strong>.<br />
                        <span class="fa fa-hand-o-right"></span> Для обращения к участнику дискуссии введите <strong>@</strong> и выберите пользователя.
                    </div>
                    <div class="editor-actions">
                        <?= Html::submitButton('Создать тему', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    <?= Sidebar::widget() ?>
</div>

