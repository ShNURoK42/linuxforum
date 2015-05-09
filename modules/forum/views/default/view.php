<?php

use yii\helpers\Url;
use app\widgets\LinkPager;
use forum\widgets\TopicPager;

/**
 * @var \app\components\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array|\yii\db\ActiveRecord[] $topics
 * @var \forum\models\Forum $forum
 * @var \topic\models\Topic $topic
 */

//$this->title = $forum->name;

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;
\forum\ForumAsset::register($this);
?>
<div class="pviewforum">
    <div class="question-list-header">
        <div class="question-list-title"><h3><?= $forum->name ?></h3></div>
        <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
        <div class="question-list--topic-create">
            <a class="btn btn-sm btn-outline" href="<?= Url::toRoute(['/topic/default/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
        </div>
        <?php endif; ?>
    </div>
    <div class="question-list">
        <?php foreach ($topics as $topic): ?>
        <div class="question-row<?= ($topic->sticked) ? ' question-row-sticked' : '' ?><?= ($topic->closed) ? ' question-row-closed' : '' ?>">
            <div class="question-info">
                <div class="views">
                    <div class="mini-counts"><span title="41 views"><?= Yii::$app->formatter->asInteger($topic->number_views) ?></span></div>
                    <div>просмотров</div>
                </div>
                <div class="answers <?= ($topic->number_posts == 0) ? '' : ' answered' ?>">
                    <div class="mini-counts"><span title="2 answers"><?= Yii::$app->formatter->asInteger($topic->number_posts) ?></span></div>
                    <div>ответов</div>
                </div>
            </div>
            <div class="question-summary">
                <h3>
                    <a href="<?= Url::toRoute(['/topic/default/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a>
                    <?= TopicPager::widget(['topic' => $topic]) ?>
                </h3>
                <div class="question-tags">
                    <a rel="tag" title="" href="<?= Url::toRoute(['/forum/default/view', 'id' => $forum->id]) ?>"><?= $forum->name ?></a>
                </div>
                <div class="question-author">
                    <?= ($topic->number_posts == 0) ? 'вопрос задал' : 'последним ответил ' ?> <a href=""><?= $formatter->asText($topic->last_post_username) ?></a> <a class="muted-link" href=""><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>