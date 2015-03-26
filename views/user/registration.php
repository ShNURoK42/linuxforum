<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;
use app\models\forms\RegistrationForm;

/* @var \app\components\View $this */
/* @var RegistrationForm $model */

$this->title = 'Регистрация в сообществе';
$this->subtitle = 'Присоединяйтесь к нам прямо сейчас!';
$this->params['page'] = 'register';
?>
<div class="page-registration">
    <div class="formbox formbox-medium formbox-center">
        <div class="formbox-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '<p><strong>Исправьте следующие ошибки:</strong></p>',
                'class' => 'form-warning',
            ]) ?>
            <?= $form->field($model, 'email')
                ->label('Электронная почта') ?>
            <?= $form->field($model, 'username')
                ->label('Ваше имя') ?>
            <?= Html::submitButton('Регистрация в сообществе', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="formbox-footer">
            <p>У вас уже есть учетная запись? <a href="<?= Url::toRoute('user/login') ?>">Пожалуйста авторизуйтесь.</a></p>
            <p>Не получается вспомнить пароль? <a href="<?= Url::toRoute('user/forget') ?>">Вы можете его сменить.</a></p>
        </div>
    </div>
</div>