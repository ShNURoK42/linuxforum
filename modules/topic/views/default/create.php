<?php

use yii\helpers\Url;
use forum\models\Forum;
use editor\Editor;


/** @var \app\components\View $this */
/** @var Forum $forum */

$this->title = Yii::t('app/topic', 'Title') . ' в разделе ' . $forum->name;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['forum/view', 'id' => $forum->id]) . '">' . $forum->name . '</a>';

?>
<div class="page-create-topic">
    <?= Editor::widget([
        'model' => $model,
        'titleAttribute' => 'subject',
        'messageAttribute' => 'message',
    ]) ?>
</div>
