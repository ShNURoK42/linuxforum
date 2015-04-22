<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\LinkPager;
use editor\Editor;
use post\Post;

/* @var \app\components\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \yii\db\ActiveRecord[] $posts */
/* @var \topic\models\Topic $topic */
/* @var \post\models\Post $post */
/* @var \post\models\PostForm $model */

$users = ArrayHelper::getColumn($posts, 'user');
$usernames = ArrayHelper::getColumn($users, 'username');
$author = implode(', ', array_unique($usernames));

$this->title = $topic->subject;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['/forum/default/view', 'id' => $topic->forum->id]) . '">' . $topic->forum->name . '</a>';
$this->description = $topic->subject;
$this->author = $author;

$item['post_count'] = $dataProvider->pagination->offset;
?>
<div class="page-viewtopic">
    <div id="t<?= $topic->id ?>" class="topic-discussion">
        <?php foreach($posts as $post): ?>
            <?php $item['post_count']++ ?>
            <?= Post::widget([
                'model' => $post,
                'topic' => $topic,
                'count' => $item['post_count'],
            ]) ?>
        <?php endforeach; ?>
    </div>
    <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
        <?= Editor::widget([
            'model' => $model,
            'messageAttribute' => 'message',
        ]) ?>
    <?php endif; ?>
    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>
<?php $this->registerJs("jQuery(document).post();") ?>