<?php
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use cebe\gravatar\Gravatar;
use app\helpers\AccessHelper;
use app\models\Post;
use app\models\Topic;
use app\widgets\Breadcrumbs;
use app\widgets\LinkPager;

/* @var \app\components\View $this */
/* @var ActiveDataProvider $dataProvider */
/* @var ActiveRecord[] $posts */
/* @var Topic $topic */
/* @var Post $post */

$users = ArrayHelper::getColumn($posts, 'user');
$usernames = ArrayHelper::getColumn($users, 'username');
$author = implode(', ', array_unique($usernames));

$this->title = $topic->subject;
$this->description = $topic->subject;
$this->author = $author;

$formatter = Yii::$app->formatter;

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
    <div class="blockpost <?= ($item['post_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($item['post_count'] == 1) ? ' firstpost' : '' ?>" id="p<?= $post->id ?>">
        <h2><span><span class="conr"><?= ($topic->first_post_user_id == $post->user->id) ? '<span class="post-author-label">Автор темы</span>' : '' ?> <a href="<?= Url::toRoute(['post/view', 'id' => $post->id, '#' => 'p' . $post->id]) ?>">#<?= $item['post_count'] ?></a></span><?= $formatter->asDatetime($post->created_at) ?></span></h2>
        <div class="box">
            <div class="inbox">
                <div class="postbody">
                    <div class="postleft">
                        <dl>
                            <dt><strong><a href="<?= Url::toRoute(['user/view', 'id' => $post->user_id])?>"><?= $post->user->username ?></a></strong></dt>
                            <dd class="usertitle"><strong><?= $formatter->asText($post->user->displayTitle) ?></strong></dd>
                            <dd class="postavatar"><?php echo Gravatar::widget([
                                    'email' => $post->user->email,
                                    'options' => [
                                        'alt' => $post->user->username,
                                    ],
                                    'defaultImage' => 'retro',
                                    'size' => 80
                                ]); ?></dd>
                            <dd><span><strong>Дата регистрации:</strong> <?= $formatter->asDate($post->user->registered) ?></span></dd>
                            <dd><span><strong>Сообщений:</strong> <?= Yii::$app->formatter->asInteger($post->user->num_posts) ?></span></dd>
                        </dl>
                    </div>
                    <div class="postright">
                        <h3><?= $formatter->asText($topic->subject) ?></h3>
                        <div class="postmsg"><?= $post->displayMessage ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        <fieldset>
            <div class="infldset txtarea">
                <?= $form->field($model, 'message', [
                    'template' => "{label}\n{input}",
                ])->textarea()
                    ->label(\Yii::t('app/topic', 'Message')) ?>
                <ul class="bblinks">
                    <li>Поддержка: <a onclick="window.open(this.href); return false;" href="http://rukeba.com/by-the-way/markdown-sintaksis-po-russki/">markdown</a></li>
                </ul>
            </div>
        </fieldset>
        <p class="buttons">
            <?= Html::submitButton(\Yii::t('app/topic', 'Submit')) ?>
        </p>
        <?php ActiveForm::end() ?>
    </div>
    <?php endif; ?>
</div>