<?php
use yii\helpers\Url;

/** @var \notify\models\UserMention $model */
/** @var \topic\models\Topic $topic */
?>
В теме "<?= $topic->subject ?>" к вам обратился пользователь <?= $model->mentionUser-> username ?>.
Просмотреть сообщение <?= Url::toRoute(['/topic/post/view', 'id' => $model->post_id], true)?>.
