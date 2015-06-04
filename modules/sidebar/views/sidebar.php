<?php

use yii\helpers\Url;
use tag\models\Tag;

/**
 * @var \tag\models\Tag $tagModel
 */

?>
<div class="sidebar">
    <?php if ($tagModel instanceof Tag): ?>
    <div class="sidebar-module">
        <div class="summarycount"><?= Yii::$app->formatter->asInteger($tagModel->countTopics) ?></div>
        <p>топиков отмеченны тегом</p>
        <a class="tag-url" href="<?= Url::toRoute(['/topic/default/list','name' => $tagModel->name]) ?>"><?= Yii::$app->formatter->asText($tagModel->name) ?></a>
    </div>
    <?php endif; ?>
    <div class="sidebar-module">
        <h4>Список доступных тегов</h4>
        <div class="interesting-tags">
            <?php foreach(Tag::getNamesList() as $name): ?>
                <a class="tag-url" href="<?= Url::toRoute(['/topic/default/list','name' => $name])?>"><?= $name ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>