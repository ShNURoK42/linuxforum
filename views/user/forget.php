<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var \app\components\View $this */
/* @var \app\models\forms\ForgetForm $model */

$this->title = \Yii::t('app/forget', 'Title');
$this->params['page'] = 'login';
?>
<?php if ($model->hasErrors()): ?>
<?= Html::errorSummary($model, [
    'class' => 'callout callout-danger',
    'header' => '<h2>' . \Yii::t('app/register', 'Error summary') . '</h2>',
]) ?>
<?php endif; ?>
<div class="blockform">
    <h2><span><?= $this->title ?></span></h2>
    <div class="box">
        <?php $form = ActiveForm::begin([
            'options' => ['id' => 'request_pass'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <div class="inform">
            <fieldset>
                <legend><?= \Yii::t('app/forget', 'Legend') ?></legend>
                <div class="infldset">
                    <?= $form->field($model, 'email', [
                        'template' => "{label}\n{input}\n<p>" . \Yii::t('app/forget', 'Email info') . "</p>",
                    ])->textInput([
                        'size' => 50,
                        'maxlength' => 255,
                    ])->label(\Yii::t('app/forget', 'Email')) ?>
                </div>
            </fieldset>
        </div>
        <p class="buttons"><?= Html::submitButton(\Yii::t('app/forget', 'Submit')) ?></p>
        <?php ActiveForm::end() ?>
    </div>
</div>
