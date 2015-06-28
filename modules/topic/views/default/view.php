<?php

/* @var \common\components\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \topic\models\Topic $topic */
/* @var \post\models\CreateForm $model */

use yii\widgets\ListView;
use common\widgets\LinkPager;
use sidebar\Sidebar;

$formatter = Yii::$app->formatter;
$topic = $dataProvider->getModels()[0]->topic;

//$users = ArrayHelper::getColumn($posts, 'user');
//$usernames = ArrayHelper::getColumn($users, 'username');
//$author = implode(', ', array_unique($usernames));

$this->title = $topic->subject;
//$this->description = $topic->subject;
//$this->author = $author;
?>
<div class="p-topic-view">
    <div class="topic-content">
        <div class="question-header">
            <h1><?= $formatter->asText($this->title) ?></h1>
        </div>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'postlist js-postlist', 'data-topic-id' => $topic->id, 'data-topic-page' => $dataProvider->pagination->page + 1],
            'layout' => "{items}",
            'itemOptions' => ['tag' => false],
            'itemView' => function ($model, $key, $index, $widget) use ($dataProvider) {
                return $this->render('_view_post', [
                    'model' => $model,
                    'key' => $key,
                    'index' => $index,
                    'widget' => $widget,
                ]);
            },
        ]) ?>
        <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
            <?= $this->render('_view_form', [
                'model' => $model,
            ]) ?>
        <?php endif; ?>
        <div class="pagination-center">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination
            ]) ?>
        </div>
    </div>
    <?= Sidebar::widget() ?>
</div>