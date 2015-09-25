<?php

/* @var \topic\models\Topic $model */
/* @var \yii\widgets\ListView $widget */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var integer $index */
/* @var integer $key */

use yii\helpers\Url;
?>
<div class="question-row">
    <div class="question-row__stats">
        <div class="question-row__tile question-row__votes">
            <div class="question-row__count">
                <span class="question-row__number" title="0 голосов">0</span>
            </div>
            <div class="question-row__text">голосов</div>
        </div>
        <div class="question-row__tile question-row__status<?= ($model->number_posts == 0) ? '' : ' question-row__status-answered' ?>">
            <div class="question-row__count">
                <span class="question-row__number" title="<?= Yii::$app->formatter->asInteger($model->number_posts) ?> <?= Yii::$app->formatter->numberEnding($model->number_posts, ['ответ', 'ответа', 'ответов']) ?>"><?= Yii::$app->formatter->asNumberAbbreviation($model->number_posts) ?></span>
            </div>
            <div class="question-row__text"><?= Yii::$app->formatter->numberEnding($model->number_posts, ['ответ', 'ответа', 'ответов']) ?></div>
        </div>
        <div class="question-row__tile question-row__views">
            <div class="question-row__count">
                <span class="question-row__number" title="<?= Yii::$app->formatter->asInteger($model->number_views) ?> просмотров"><?= Yii::$app->formatter->asNumberAbbreviation($model->number_views) ?></span>
            </div>
            <div class="question-row__text">показов</div>
        </div>
    </div>
    <div class="question-row__summary">
        <h6><a href="<?= Url::toRoute(['/topic/default/view', 'id' => $model->id])?>"><?= Yii::$app->formatter->asText($model->subject) ?></a></h6>
        <div class="question-row__tags">
            <?php foreach ($model->tags as $tag): ?>
                <a class="tag-link question-row__tag-link" title="" href="<?= Url::toRoute(['/topic/default/list', 'name' => $tag->name]) ?>"><?= $tag->name ?></a>
            <?php endforeach; ?>
        </div>
        <div class="question-row__author-stat">спросил
            <a class="question-row__date-link" href="<?= Url::toRoute([
                '/post/default/view',
                'id' => $model->first_post_id,
                '#' => 'post' . $model->first_post_id
            ]) ?>"><time datetime="<?= Yii::$app->formatter->asDatetime($model->first_post_created_at, 'php:c') ?>" title="<?= Yii::$app->formatter->asDatetime($model->first_post_created_at, 'long') ?>"><?= Yii::$app->formatter->asRelativeTime($model->first_post_created_at) ?></time></a>
            <a href="<?= Url::toRoute(['/user/default/view', 'id' => $model->first_post_user_id]) ?>"><?= Yii::$app->formatter->asText($model->first_post_username) ?></a>
        </div>
    </div>
</div>