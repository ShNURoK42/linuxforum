<?php
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\AccessHelper;
use app\models\Post;
use app\models\Topic;
use app\models\forms\PostForm;
use app\widgets\Breadcrumbs;
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
$this->description = $topic->subject;
$this->author = $author;

$this->params = [
    'page' => 'viewforum',
    'breadcrumbs' => [
        ['label' => $topic->forum->forum_name, 'url' => ['forum/view', 'id' => $topic->forum->id]],
        ['label' => $topic->subject]
    ],
];

$item['post_count'] = $dataProvider->pagination->offset;
?>
<div id="brdmain">
    <div class="linkst">
        <div class="inbox crumbsplus">
            <?= Breadcrumbs::widget() ?>
            <div class="pagepost">
                <div class="pagelink conl">
                    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
                </div>
            </div>
            <div class="clearer"></div>
        </div>
    </div>
    <?php foreach($posts as $post): ?>
        <?php $item['post_count']++ ?>
        <?= $this->render('/post/view', ['topic' => $topic, 'post' => $post, 'count' => $item['post_count']])?>
    <?php endforeach; ?>
    <div class="linksb">
        <div class="inbox crumbsplus">
            <div class="pagepost">
                <div class="pagelink conl">
                    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
                </div>
            </div>
            <?= Breadcrumbs::widget() ?>
            <div class="clearer"></div>
        </div>
    </div>

    <?php if (AccessHelper::canPostReplyInTopic($topic)): ?>
    <?php if ($model->hasErrors()): ?>
        <?= Html::errorSummary($model, [
            'class' => 'callout callout-danger',
            'header' => '<h2>' . \Yii::t('app/register', 'Error summary') . '</h2>',
        ]) ?>
    <?php endif; ?>
    <div class="blockform" id="quickpost">
        <?php $form = ActiveForm::begin([
            'action' => ['topic/view', 'id' => $topic->id, '#' => 'quickpostform'],
            'options' => ['id' => 'quickpostform'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <div class="post-form-head">
            <nav class="tabnav-tabs">
                <a class="tabnav-tab write-tab js-write-tab selected" href="#">Набор сообщения</a>
                <a class="tabnav-tab preview-tab js-preview-tab" href="#">Предпросмотр</a>
            </nav>
        </div>
        <div class="infldset txtarea">
            <fieldset>
                <?= $form->field($model, 'message', [
                    'template' => "{label}\n{input}",
                ])->textarea()
                    ->label(\Yii::t('app/topic', 'Message')) ?>
                <ul class="bblinks">
                    <li>Поддержка: <a onclick="window.open(this.href); return false;" href="http://rukeba.com/by-the-way/markdown-sintaksis-po-russki/">markdown</a></li>
                </ul>
            </fieldset>
            <div class="post-preview">Preview</div>
        </div>
        <p class="buttons">
            <?= Html::submitButton(\Yii::t('app/topic', 'Submit')) ?>
        </p>
        <?php ActiveForm::end() ?>
    </div>
    <?php endif; ?>
</div>
<?php $this->registerJs("jQuery('#quickpostform').post();") ?>