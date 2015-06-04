<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\LinkPager;
use editor\Editor;
use post\Post;
use sidebar\Sidebar;

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
$this->description = $topic->subject;
$this->author = $author;

$formatter = Yii::$app->formatter;

\topic\TopicAsset::register($this);

$item['post_count'] = $dataProvider->pagination->offset;
?>

<div class="p-viewtopic">
    <div class="topic-content">
        <div class="question-header">
            <h1><?= $formatter->asText($this->title) ?></h1>
        </div>
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
            'activeFormOptions' => [
                'action' => Url::to(['/topic/default/view', 'id' => $topic->id, '#' => 'postform']),
            ],
            'model' => $model,
            'messageAttribute' => 'message',
        ]) ?>
        <?php endif; ?>
        <div class="pagination-center">
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
    <?= Sidebar::widget() ?>
</div>


<?php $this->registerJs("jQuery(document).post();") ?>