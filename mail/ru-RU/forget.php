<?php

use yii\helpers\Url;

/* @var \app\models\User $user */
/* @var string $password new user password */
/* @var string $token password recovery token */
?>
Здравствуйте, <?= $user->username ?>!

Вы сделали запрос на изменение пароля на сайте <?= \Yii::$app->config->get('site_title') ?>.
Если это не вы или если вы не хотите менять пароль, просто проигнорируйте это письмо.

Чтобы изменить пароль, пожалуйста, пройдите по этой ссылке:
<?= Url::to(['user/change', 'token' => $token], true) ?>


--
(Не отвечайте на это сообщение)