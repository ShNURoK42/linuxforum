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

$this->title = $forum->name;

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;
?>
<div class="pviewforum">
    <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
    <div class="topic-list-header clearfix">
        <span class="topic-create-link">
            <a href="<?= Url::toRoute(['/topic/default/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
        </span>
    </div>
    <?php endif; ?>
    <div class="topics-list">
        <?php foreach ($topics as $topic): ?>
        <div class="topic-row<?= ($topic->sticked) ? ' sticked' : '' ?><?= ($topic->closed) ? ' closed' : '' ?>">
            <div class="topic-row-icon"><?= ($topic->sticked) ? '<span class="octicon octicon-pin"></span>' : '<span class="octicon octicon-primitive-dot"></span>' ?></div>
            <div class="topic-row-cell left">
                <a class="topic-row-link" href="<?= Url::toRoute(['/topic/default/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a>
                <?= TopicPager::widget(['topic' => $topic]) ?>
                <div class="topic-row-meta">
                    <span>Тему создал: <a class="muted-link" href="<?= Url::toRoute(['/user/default/view', 'id' => $topic->first_post_user_id]) ?>"><?= $formatter->asText($topic->first_post_username) ?></a></span>
                    <span class="topic-last-post right"><span class="tooltipped tooltipped-w" aria-label="Сообщение от <?= $topic->last_post_username ?>"><a class="muted-link" href="<?= Url::toRoute(['/topic/post/view', 'id' => $topic->last_post_id, '#' => 'p' . $topic->last_post_id ]) ?>"><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a></span></span>
                </div>
            </div>
            <div class="<?= ($topic->number_posts == 0) ? 'topic-row-post-null' : 'topic-row-post-count' ?>"><?= Yii::$app->formatter->asInteger($topic->number_posts) ?> <span class="octicon octicon-comment-discussion"></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>