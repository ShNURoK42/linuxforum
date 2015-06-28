<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this \common\components\View */
/* @var $model \frontend\models\FeedbackForm */

$this->title = 'Обратная связь';
$this->subtitle = 'Мы надеемся, что сможем ответить на любой ваш вопрос!';
?>
<div class="pfeedback">
    <div class="authbox left">
        <div class="authbox-header">
            <p>Напишите нам письмо на <a href="mailto:<?= Yii::$app->config->get('support_email') ?>"><?= Yii::$app->config->get('support_email') ?></a> или отправьте форму.</p>
        </div>
        <div class="authbox-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '',
            ]) ?>
            <?= $form->field($model, 'name', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->label('Ваше имя') ?>
            <?= $form->field($model, 'email', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->label('Электронная почта') ?>
            <?= $form->field($model, 'message', [
                'options' => [
                    'tag' => 'dl',
                    'class' => 'form',
                ],
                'template' => "<dt>{label}</dt>\n<dd>{input}</dd>",
            ])
                ->textarea()
                ->label('Ваше сообщение') ?>
            <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="contact-content right">
        <h3>Мы будем Вам очень благодарны</h3>
        <ul class="checklist">
            <li>за полезный совет</li>
            <li>за найденную ошибку на сайте</li>
            <li>за подробное описание ситуации</li>
        </ul>
    </div>
</div>