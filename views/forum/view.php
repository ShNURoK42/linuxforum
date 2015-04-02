<?php

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;

use app\models\Forum;
use app\models\Topic;
use app\widgets\LinkPager;
use app\widgets\TopicPager;

/**
 * @var \app\components\View $this
 * @var ActiveDataProvider $dataProvider
 * @var array|ActiveRecord[] $topics
 * @var Forum $forum
 * @var Topic $topic
 */

$this->title = $forum->name;

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;
?>
<div class="page-viewforum">
    <?php if (!Yii::$app->getUser()->getIsGuest()): ?>
    <div class="topic-list-header clearfix">
        <div class="topic-create-btn">
            <a class="btn btn-primary" href="<?= Url::toRoute(['topic/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
        </div>
    </div>
    <?php endif; ?>
    <div class="topics-list">
        <?php foreach ($topics as $topic): ?>
        <div class="topic-row">
            <div class="topic-row-icon"><span class="octicon octicon-primitive-dot"></span></span></span></span></div>
            <div class="topic-row-cell left">
                <a class="topic-row-link" href="<?= Url::toRoute(['topic/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a>
                <?= TopicPager::widget(['topic' => $topic]) ?>
                <div class="topic-row-meta">
                    <span>Тему создал: <a class="muted-link" href="<?= Url::toRoute(['user/view', 'id' => $topic->first_post_user_id]) ?>"><?= $formatter->asText($topic->first_post_username) ?></a></span>
                    <span class="topic-last-post right">ответил <a class="muted-link" href="<?= Url::toRoute(['post/view', 'id' => $topic->last_post_id, '#' => 'p' . $topic->last_post_id ]) ?>"><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a> <a class="muted-link" href="<?= Url::toRoute(['user/view', 'id' => $topic->last_post_user_id]) ?>"><?= $formatter->asText($topic->last_post_username) ?></a></span>
                </div>
            </div>
            <div class="topic-row-post-count"><?= Yii::$app->formatter->asInteger($topic->number_posts) ?> <span class="octicon octicon-comment"></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>