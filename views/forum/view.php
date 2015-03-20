<?php

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;

use app\helpers\AccessHelper;
use app\models\Forum;
use app\models\Topic;
use app\widgets\Breadcrumbs;
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
$this->params['page'] = 'viewforum';
$this->params['breadcrumbs'] = [$this->title];

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;
?>
<div class="linkst">
    <div class="inbox crumbsplus">
        <?= Breadcrumbs::widget() ?>
        <div class="pagepost">
            <div class="pagelink conl">
                <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
            </div>
            <?php if(AccessHelper::canCreateTopic($forum)): ?>
            <div class="postlink conr">
                <a href="<?= Url::toRoute(['topic/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
            </div>
            <?php endif; ?>
        </div>
        <div class="clearer"></div>
    </div>
</div>
<div class="blocktable" id="vf">
    <h2><span><?= $formatter->asText($forum->forum_name) ?></span></h2>
    <div class="box">
        <div class="inbox">
            <table>
                <thead>
                <tr>
                    <th scope="col" class="tcl"><?= Yii::t('app/forum', 'Topic') ?></th>
                    <th scope="col" class="tc2"><?= Yii::t('app/forum', 'Replies') ?></th>
                    <th scope="col" class="tc3"><?= Yii::t('app/forum', 'Views') ?></th>
                    <th scope="col" class="tcr"><?= Yii::t('app/forum', 'Last post') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($topics) == 0): ?>
                <tr class="rowodd inone">
                    <td class="tcl" colspan="4">
                        <div class="icon inone"><div class="nosize"><!-- --></div></div>
                        <div class="tclcon">
                            <div>
                                <strong><?= Yii::t('app/forum', 'Empty forum') ?></strong>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($topics as $topic): ?>
                <?php $item['topic_count']++ ?>
                <tr class="<?= ($item['topic_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($topic->sticked) ? ' isticky' : ''?><?= ($topic->closed) ? ' iclosed' : ''?>">
                    <td class="tcl">
                        <div class="icon"><div class="nosize">1</div></div>
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
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="linksb">
    <div class="inbox crumbsplus">
        <div class="pagepost">
            <div class="pagelink">
                <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
            </div>
            <?php if(AccessHelper::canCreateTopic($forum)): ?>
            <div class="postlink conr">
                <a href="<?= Url::toRoute(['topic/create', 'id' => $forum->id]) ?>"><?= Yii::t('app/forum', 'Create topic') ?></a>
            </div>
            <?php endif; ?>
        </div>
        <?= Breadcrumbs::widget() ?>
        <div class="clearer"></div>
    </div>
</div>