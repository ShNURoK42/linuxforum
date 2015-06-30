<?php

use yii\helpers\Url;
use topic\widgets\Tabs;
use common\widgets\LinkPager;
use topic\widgets\TopicPager;
use tag\models\Tag;
use sidebar\Sidebar;

/**
 * @var \common\components\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array|\yii\db\ActiveRecord[] $topics
 * @var \topic\models\Topic $topic
 * @var \tag\models\Tag $tagModel
 * @var \tag\models\Tag $tag
 */

\topic\TopicAsset::register($this);

$formatter = Yii::$app->formatter;

if ($tagModel instanceof Tag) {
    $this->title = Yii::$app->formatter->asText($tagModel->short_description);
} else {
    $this->title = 'Последние темы';
}

$item['topic_count'] = 0;
?>
<div class="ptagged">
    <div class="question-content">
        <div class="question-list-header">
            <div class="question-list-title">
                <h3><?= $this->title ?></h3>
                <?= Tabs::widget(); ?>
            </div>
        </div>
        <div class="question-list">
            <?php foreach ($topics as $topic): ?>
            <div class="question-row<?= ($topic->sticked) ? ' question-row-sticked' : '' ?><?= ($topic->closed) ? ' question-row-closed' : '' ?>">
                <div class="question-info">
                    <div class="views">
                        <div class="mini-counts"><span title="<?= Yii::$app->formatter->asInteger($topic->number_views) ?> просмотров"><?= Yii::$app->formatter->asInteger($topic->number_views) ?></span></div>
                        <div>просмотров</div>
                    </div>
                    <div class="answers <?= ($topic->number_posts == 0) ? '' : ' answered' ?>">
                        <div class="mini-counts"><span title="<?= Yii::$app->formatter->asInteger($topic->number_posts) ?> ответов"><?= Yii::$app->formatter->asInteger($topic->number_posts) ?></span></div>
                        <div>ответов</div>
                    </div>
                </div>
                <div class="question-summary">
                    <h3>
                        <a href="<?= Url::toRoute(['/topic/default/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a>
                        <?= TopicPager::widget(['topic' => $topic]) ?>
                    </h3>
                    <div class="question-tags">
                        <?php foreach ($topic->tags as $tag): ?>
                        <a  class="tag-url" title="" href="<?= Url::toRoute(['/topic/default/list', 'name' => $tag->name]) ?>"><?= $tag->name ?></a>
                        <?php endforeach; ?>
                    </div>
                    <div class="question-author-box">
                        <div class="question-author-avatar">
                            <?= \cebe\gravatar\Gravatar::widget([
                                'email' => $topic->lastPostUser->email,
                                'options' => [
                                    'alt' => $topic->lastPostUser->username,
                                    'class' => 'avatar',
                                    'width' => 32,
                                    'height' => 32,
                                ],
                                'defaultImage' => 'retro',
                                'size' => 32
                            ]); ?>
                        </div>
                        <div class="question-author-time">
                            <a class="muted-link" href="<?= Url::toRoute(['/post/default/view', 'id' => $topic->last_post_id, '#' => 'post' . $topic->last_post_id]) ?>"><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a>
                        </div>
                        <div class="question-author-info">
                            <a href="<?= Url::toRoute(['/user/default/view', 'id' => $topic->last_post_user_id]) ?>"><?= $formatter->asText($topic->last_post_username) ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination-center">
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
    <?= Sidebar::widget() ?>
</div>