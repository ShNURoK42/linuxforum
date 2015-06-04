<?php

use editor\Editor;


/** @var \app\components\View $this */

$this->title = 'Создание новой темы';

\topic\TopicAsset::register($this);

?>
<div class="question-header">
    <h1><?= $this->title ?></h1>
</div>
<div class="page-create-topic">
    <?= Editor::widget([
        'model' => $model,
        'titleAttribute' => 'subject',
        'messageAttribute' => 'message',
    ]) ?>
</div>
