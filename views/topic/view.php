<?php
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;
use app\helpers\AccessHelper;
use app\models\Post;
use app\models\Topic;
use app\models\forms\PostForm;
use app\widgets\LinkPager;

/* @var \app\components\View $this */
/* @var ActiveDataProvider $dataProvider */
/* @var ActiveRecord[] $posts */
/* @var Topic $topic */
/* @var Post $post */
/* @var PostForm $model */

$users = ArrayHelper::getColumn($posts, 'user');
$usernames = ArrayHelper::getColumn($users, 'username');
$author = implode(', ', array_unique($usernames));

$this->title = $topic->subject;
$this->subtitle = 'вернуться в раздел <a href="' . Url::to(['forum/view', 'id' => $topic->forum->id]) . '">' . $topic->forum->forum_name . '</a>';
$this->description = $topic->subject;
$this->author = $author;

$item['post_count'] = $dataProvider->pagination->offset;
?>
<div class="view-topic">
    <div class="topic-discussion">
        <?php foreach($posts as $post): ?>
            <?php $item['post_count']++ ?>
            <?= $this->render('/post/view', ['topic' => $topic, 'post' => $post, 'count' => $item['post_count']])?>
        <?php endforeach; ?>
    </div>
    <?php if (AccessHelper::canPostReplyInTopic($topic)): ?>
    <div class="quickpost" id="quickpostform">
        <?php $form = ActiveForm::begin([
            'action' => ['topic/view', 'id' => $topic->id, '#' => 'quickpostform'],
            'options' => ['id' => 'quickpostform'],
        ]) ?>
        <div class="quickpost-header tabnav">
            <div class="right">
                <a class="tabnav-extra" target="_blank" href="http://linuxforum.ru/topic/38070"><span class="octicon octicon-markdown"></span>Поддержка markdown</a>
            </div>
            <nav class="tabnav-tabs">
                <a href="#" class="tabnav-tab js-write-tab selected">Набор сообщения</a>
                <a href="#" class="tabnav-tab js-preview-tab">Предпросмотр</a>
            </nav>
        </div>
        <?= $form->errorSummary($model, [
            'header' => '<p><strong>Исправьте следующие ошибки:</strong></p>',
            'class' => 'form-warning',
        ]) ?>
        <?= $form->field($model, 'message', [
            'template' => "{input}",
            'options' => [
                'class' => 'create-post-message',
            ],
        ])->textarea([
            'placeholder' => 'Напишите сообщение',
        ]) ?>
        <div class="post-preview postmsg markdown-body"></div>
        <div class="form-actions">
            <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    <?php endif; ?>
    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
</div>
<?php $this->registerJs("jQuery(document).post();") ?>