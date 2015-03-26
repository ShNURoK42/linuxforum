<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;
use app\models\Forum;

/** @var \app\components\View $this */
/** @var Forum $forum */

$this->title = Yii::t('app/topic', 'Title') . ' в разделе ' . $forum->forum_name;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['forum/view', 'id' => $forum->id]) . '">' . $forum->forum_name . '</a>';

?>
<div class="page-create-topic">
    <div class="formbox formbox-center">
        <div class="formbox-content">
            <?php $form = ActiveForm::begin([
                'options' => ['id' => 'post'],
            ]) ?>
            <?= $form->errorSummary($model, [
                'header' => '<p><strong>Исправьте следующие ошибки:</strong></p>',
                'class' => 'form-warning',
            ]) ?>
            <?= $form->field($model, 'subject')
            ->textInput()
            ->label(\Yii::t('app/topic', 'Subject')) ?>
            <?= $form->field($model, 'message')
            ->textarea()
            ->label(\Yii::t('app/topic', 'Message')) ?>
            <?= Html::submitButton('Создать новую тему', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
