<?php

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\Topic;
use app\widgets\Breadcrumbs;
use app\widgets\LinkPager;
use app\widgets\TopicPager;

/**
 * @var \app\components\View $this
 * @var ActiveDataProvider $dataProvider
 * @var array|ActiveRecord[] $topics
 * @var Topic $topic
 */

$this->title = 'Активные темы';
$this->params['page'] = 'search';
$this->params['breadcrumbs'] = [$this->title];

$formatter = Yii::$app->formatter;

$item['topic_count'] = 0;

// ToDo: if null
?>
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
<div class="blocktable" id="vf">
    <h2><span>Активные темы за последние сутки</span></h2>
    <div class="box">
        <div class="inbox">
            <table>
                <thead>
                <tr>
                    <th scope="col" class="tcl">Темы</th>
                    <th scope="col" class="tc2">Форум</th>
                    <th scope="col" class="tc3">Сообщений</th>
                    <th scope="col" class="tcr">Последнее сообщение</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($topics as $topic): ?>
                    <tr class="<?= ($item['topic_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?>">
                    <td class="tcl">
                        <div class="icon"><div class="nosize">1</div></div>
                        <div class="tclcon">
                            <div>
                                <a href="<?= Url::toRoute(['topic/view', 'id' => $topic->id])?>"><?= $formatter->asText($topic->subject) ?></a> <span class="byuser"><?= $formatter->asText($topic->first_post_username) ?></span>
                                <?= TopicPager::widget(['topic' => $topic]) ?>
                            </div>
                        </div>
                    </td>
                    <td class="tc2"><a href="<?= Url::toRoute(['forum/view', 'id' => $topic->forum->id])?>"><?= $topic->forum->forum_name ?></a></td>
                    <td class="tc3"><?= $formatter->asInteger($topic->number_posts) ?></td>
                    <td class="tcr"><a href="<?= Url::toRoute(['post/view', 'id' => $topic->last_post_id, '#' => 'p' . $topic->last_post_id])?>"><?= Yii::$app->formatter->asDatetime($topic->last_post_created_at) ?></a> <span class="byuser"><?= $formatter->asText($topic->last_post_username) ?></span></td>
                </tr>
                <?php endforeach; ?>
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
        </div>
        <?= Breadcrumbs::widget() ?>
        <div class="clearer"></div>
    </div>
</div>