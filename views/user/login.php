<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;
use app\models\forms\LoginForm;

/* @var \app\components\View $this */
/* @var LoginForm $model */

$this->title = 'Вход в сообщество';
?>
<div class="page-login">
    <div class="formbox formbox-medium formbox-center">
        <div class="formbox-content">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->errorSummary($model, [
                'header' => '<p><strong>Исправьте следующие ошибки:</strong></p>',
                'class' => 'form-warning',
            ]) ?>
            <?= $form->field($model, 'email')
                ->label('Электронная почта') ?>
            <?= $form->field($model, 'password')
                ->passwordInput()
                ->label('Пароль') ?>
            <?= $form->field($model, 'remember', ['options' => ['class' => 'form-checkbox']])
                ->checkbox(['label' => 'Запомнить меня на этом компьютере?']) ?>
            <?= Html::submitButton('Войти в сообщество', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="formbox-footer">
            <p>Нет учетной записи? <a href="<?= Url::toRoute('user/registration') ?>">Присоединяйтесь к нам прямо сейчас!</a></p>
            <p>Не получается вспомнить пароль? <a href="<?= Url::toRoute('user/forget') ?>">Вы можете его сменить.</a></p>
        </div>
    </div>
</div>

