<?php

/* @var \post\models\Post $model */
/* @var \yii\widgets\ListView $widget */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var integer $index */
/* @var integer $key */

use yii\helpers\Url;
use post\widgets\Post;

$dataProvider = $widget->dataProvider;
$count = ($dataProvider->pagination->page * 15) + $index + 1;
?>
<?= Post::widget([
    'post' => $model,
    'count' => $count,
]) ?>
<?php if ($index == 0): ?>
<div class="topic-tags">
    <span class="fa fa-tags topic-tags-fa"></span>
    <?php foreach($model->topic->tags as $tag): ?>
    <a class="tag-url" href="<?= Url::toRoute(['/topic/default/list', 'name' => $tag->name]) ?>"><?= $tag->name ?></a>
    <?php endforeach ?>
</div>
<?php endif ?>
