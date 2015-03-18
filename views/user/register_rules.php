<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \app\components\View $this
 * @var \app\models\forms\RegisterForm $model
 */

$this->title = \Yii::t('app/register', 'Title');
$this->params['page'] = 'register';
?>
<div id="rules" class="blockform">
    <div class="hd"><h2><span><?= \Yii::t('app/common', 'Forum rules') ?></span></h2></div>
    <div class="box">
        <?php $form = ActiveForm::begin([
            'action' => ['user/register'],
            'method' => 'get',
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <?= $form->field($model, 'agree', [
            'template' => "{input}",
            ])->hiddenInput([
                'name' => 'agree',
                'value' => true,
            ]) ?>
            <div class="inform">
                <fieldset>
                    <legend><?= \Yii::t('app/register', 'Rules legend') ?></legend>
                    <div class="infldset">
                        <div class="usercontent">
                            <?= Yii::$app->config->get('o_rules_message') ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <p class="buttons">
                <?= Html::submitButton(\Yii::t('app/register', 'Rules agree')) ?>
                <?= Html::submitButton(\Yii::t('app/register', 'Rules cancel'), [
                    'onclick' => "window.location='" . Url::toRoute('site/index') . "';return false;"
                ]) ?>
            </p>
        <?php ActiveForm::end() ?>
    </div>
</div>