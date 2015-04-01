<?php

use yii\helpers\Url;

/* @var \app\models\User $user */
/* @var string $password new user password */
/* @var string $token password recovery token */
?>
Здравствуйте, <?= $user->username ?>!

Вы сделали запрос на смену пароля аккаунта на форуме <?= \Yii::$app->config->get('site_title') ?>.
Если это не вы или если вы не хотите менять пароль, просто проигнорируйте это письмо.
Ваш пароль изменится только если вы посетите активационную ссылку.

Ваш новый пароль: <?= $password ?>


Чтобы установить этот пароль, пожалуйста, пройдите по этой ссылке:
<?= Url::to(['user/forget-change', 'token' => $token], true) ?>


--
(Не отвечайте на это сообщение)