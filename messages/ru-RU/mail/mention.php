<?php
use yii\helpers\Url;

/** @var \notify\models\UserMention $model */
/** @var \topic\models\Topic $topic */
?>
Здравствуйте, <?= $model->mentionUser->username ?>!

В теме "<?= $topic->subject ?>" к вам обратился пользователь <?= $model->user->username ?>.

Если вы хотите просмотреть сообщение, перейдите по следующей ссылке:
<?= Url::toRoute(['/topic/post/view', 'id' => $model->post_id], true) . '#p' . $model->post_id ?>


Если вы хотите просмотреть всю тему, перейдите по следующей ссылке:
<?= Url::toRoute(['/topic/default/view', 'id' => $model->topic_id], true) ?>


--
(Не отвечайте на это сообщение)