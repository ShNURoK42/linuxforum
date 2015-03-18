<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\forms\RegisterForm;

/* @var \app\components\View $this */
/* @var RegisterForm $model */

$this->title = \Yii::t('app/register', 'Title');
$this->params['page'] = 'register';
?>
<?php if ($model->hasErrors()): ?>
<?= Html::errorSummary($model, [
    'class' => 'callout callout-danger',
    'header' => '<h2>' . \Yii::t('app/register', 'Error summary') . '</h2>',
]) ?>
<?php endif; ?>
<div id="regform" class="blockform">
    <h2><span><?= $this->title ?></span></h2>
    <div class="box">
        <?php $form = ActiveForm::begin([
            'options' => ['id' => 'register'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <div class="inform">
                <fieldset>
                    <legend><?= \Yii::t('app/register', 'Email legend') ?></legend>
                    <div class="infldset">
                        <?= $form->field($model, 'email', [
                            'template' => "{label}\n{input}",
                        ])->textInput([
                            'size' => 50,
                            'maxlength' => 80,
                        ])->label(\Yii::t('app/register', 'Email')) ?>
                    </div>
                </fieldset>
            </div>
            <div class="inform">
                <fieldset>
                    <legend><?= \Yii::t('app/register', 'Username legend') ?></legend>
                    <div class="infldset">
                        <?= $form->field($model, 'username', [
                            'template' => "{label}\n{input}",
                        ])->textInput([
                            'size' => 25,
                            'maxlength' => 25,
                        ])->label(\Yii::t('app/register', 'Username')) ?>
                    </div>
                </fieldset>
            </div>
        <p class="buttons"><?= Html::submitButton(\Yii::t('app/register', 'Submit')) ?></p>
        <?php ActiveForm::end() ?>
    </div>
</div>