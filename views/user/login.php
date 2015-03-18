<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\forms\LoginForm;

/* @var \app\components\View $this */
/* @var LoginForm $model */

$this->title = \Yii::t('app/login', 'Title');
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
            'options' => ['id' => 'login'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <div class="inform">
            <fieldset>
                <legend><?= \Yii::t('app/login', 'Legend') ?></legend>
                <div class="infldset">
                    <?= $form->field($model, 'email', [
                        'template' => "{label}\n{input}",
                    ])->textInput([
                        'size' => 25,
                        'maxlength' => 80,
                    ])->label(\Yii::t('app/login', 'Email')) ?>
                    <?= $form->field($model, 'password', [
                        'template' => "{label}\n{input}",
                    ])->passwordInput([
                        'size' => 25,
                    ])->label(\Yii::t('app/login', 'Password')) ?>
                    <div class="rbox clearb">
                        <?= $form->field($model, 'remember')
                            ->checkbox(['label' => \Yii::t('app/login', 'Remember')]) ?>
                    </div>
                    <p class="clearb"></p>
                    <p class="actions">
                        <span><a href="<?= Url::toRoute('user/register') ?>"><?= \Yii::t('app/login', 'Not registered') ?></a></span>
                        <span><a href="<?= Url::toRoute('user/forget') ?>"><?= \Yii::t('app/login', 'Forgotten password') ?></a></span>
                    </p>
                </div>
            </fieldset>
        </div>
        <p class="buttons"><?= Html::submitButton(\Yii::t('app/login', 'Submit')) ?></p>
        <?php ActiveForm::end() ?>
    </div>
</div>

