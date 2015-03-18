<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\widgets\Breadcrumbs;
use app\models\Forum;

/** @var \app\components\View $this */
/** @var Forum $forum */

$this->title = Yii::t('app/topic', 'Title');
$this->params = [
    'page' => 'post',
    'breadcrumbs' => [
        ['label' => $forum->forum_name, 'url' => ['forum/view', 'id' => $forum->id]],
        ['label' => $this->title]
    ],
];
?>
<div class="linkst">
    <div class="inbox">
        <?= Breadcrumbs::widget() ?>
    </div>
</div>
<?php if ($model->hasErrors()): ?>
<?= Html::errorSummary($model, [
    'class' => 'callout callout-danger',
    'header' => '<h2>' . \Yii::t('app/register', 'Error summary') . '</h2>',
]) ?>
<?php endif; ?>
<div class="blockform" id="postform">
    <h2><span><?= $this->title ?></span></h2>
    <div class="box">
        <?php $form = ActiveForm::begin([
            'options' => ['id' => 'post'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
            <div class="inform">
                <fieldset>
                    <legend>Введите сообщение и нажмите Отправить</legend>
                    <div class="infldset txtarea">
                        <?= $form->field($model, 'subject', [
                            'template' => "{label}\n{input}",
                        ])->textInput([
                            'size' => 70,
                            'maxlength' => 255,
                        ])->label(\Yii::t('app/topic', 'Subject')) ?>
                        <?= $form->field($model, 'message', [
                            'template' => "{label}\n{input}",
                        ])->textarea([
                            'cols' => 95,
                            'rows' => 20,
                        ])->label(\Yii::t('app/topic', 'Message')) ?>
                        <ul class="bblinks">
                            <li>Поддержка: <a onclick="window.open(this.href); return false;" href="http://rukeba.com/by-the-way/markdown-sintaksis-po-russki/">markdown</a></li>
                        </ul>
                    </div>
                </fieldset>
            </div>
            <p class="buttons"><?= Html::submitButton(\Yii::t('app/topic', 'Submit')) ?></p>
        <?php ActiveForm::end() ?>
    </div>
</div>
