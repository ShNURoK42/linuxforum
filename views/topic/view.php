<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\PostFormbox;
use app\widgets\LinkPager;

/* @var \app\components\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \yii\db\ActiveRecord[] $posts */
/* @var \app\models\Topic $topic */
/* @var \app\models\Post $post */
/* @var \app\models\forms\PostForm $model */

$users = ArrayHelper::getColumn($posts, 'user');
$usernames = ArrayHelper::getColumn($users, 'username');
$author = implode(', ', array_unique($usernames));

$this->title = $topic->subject;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['forum/view', 'id' => $topic->forum->id]) . '">' . $topic->forum->name . '</a>';
$this->description = $topic->subject;
$this->author = $author;

$item['post_count'] = $dataProvider->pagination->offset;
?>
<div class="page-viewtopic">
    <div class="topic-discussion">
        <?php foreach($posts as $post): ?>
            <?php $item['post_count']++ ?>
            <?= $this->render('/post/view', ['topic' => $topic, 'post' => $post, 'count' => $item['post_count']])?>
        <?php endforeach; ?>
    </div>
    <div class="topic-discussion-end"></div>
    <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
        <?= PostFormbox::widget([
            'model' => $model,
            'messageAttribute' => 'message',
            'activeFormOptions' => [
                'action' => ['topic/view', 'id' => $topic->id, '#' => 'postform'],
            ],
        ]) ?>
    <?php endif; ?>
    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
<?php $this->registerJs("jQuery(document).post();") ?>