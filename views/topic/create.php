<?php

use yii\helpers\Url;
use app\models\Forum;
use app\widgets\PostFormbox;


/** @var \app\components\View $this */
/** @var Forum $forum */

$this->title = Yii::t('app/topic', 'Title') . ' в разделе ' . $forum->name;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['forum/view', 'id' => $forum->id]) . '">' . $forum->name . '</a>';

?>
<div class="page-create-topic">
    <?= PostFormbox::widget([
        'model' => $model,
        'titleAttribute' => 'subject',
        'messageAttribute' => 'message',
    ]) ?>
</div>
