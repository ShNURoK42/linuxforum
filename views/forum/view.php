<?php

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;

use app\helpers\AccessHelper;
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

$this->title = $forum->forum_name;

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;
?>
<div class="page-view-forum">
    <?php if (AccessHelper::canCreateTopic($forum)): ?>
    <div class="new-topic-btn clearfix">
        <a class="btn btn-primary right" href="<?= Url::toRoute(['topic/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
    </div>
    <?php endif; ?>
    <table class="table table-hover">
        <tbody>
        <?php foreach ($topics as $topic): ?>
        <?php $item['topic_count']++ ?>
        <tr class="<?= ($item['topic_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($topic->sticked) ? ' isticky' : ''?><?= ($topic->closed) ? ' isclosed' : ''?>">
            <td class="table-column-title">
                <div class="tclcon">
                    <div>
                        <?php if ($topic->sticked): ?>
                            <span class="stickytext">Важно:</span>
                        <?php endif; ?>
                        <?php if ($topic->closed): ?>
                            <span class="closedtext">Закрыто:</span>
                        <?php endif; ?>
                        <a href="<?= Url::toRoute(['topic/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a>
                        <span class="byuser"><?= $topic->first_post_username ?></span>
                        <?= TopicPager::widget(['topic' => $topic]) ?>
                    </div>
                </div>
            </td>
            <td class="tc2"><?= Yii::$app->formatter->asInteger($topic->number_posts) ?></td>
            <td class="tc3"><?= Yii::$app->formatter->asInteger($topic->number_views) ?></td>
            <td class="tcr">
                <a href="<?= Url::toRoute(['post/view', 'id' => $topic->last_post_id, '#' => 'p' . $topic->last_post_id ]) ?>"><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a>
                <span class="byuser"><?= $formatter->asText($topic->last_post_username) ?></span>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-center">
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</div>