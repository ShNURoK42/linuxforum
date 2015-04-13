<?php

use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\Category;
use app\models\Forum;
use app\models\Online;

/**
 * @var \app\components\View $this
 * @var ActiveRecord[] $categories
 * @var Category $category
 * @var Forum $forum
 */
$item = [
    'forum_count' => 0,
    'category_count' => 0,
];

$formatter = Yii::$app->formatter;
?>
<div class="page-index">
    <?php foreach($categories as $category): ?>
    <?php $item['category_count']++ ?>
    <div id="category<?= $item['category_count'] ?>" class="columns">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class=""><?= $formatter->asText($category->name) ?></th>
                    <th class="tens"><?= Yii::t('app/index', 'Topics') ?></th>
                    <th class="tens"><?= Yii::t('app/index', 'Posts') ?></th>
                    <th class="one-fourth"><?= Yii::t('app/index', 'Last post') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($category->forums as $forum): ?>
                <?php $item['forum_count']++ ?>
                <tr class="<?= ($item['forum_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?>">
                    <td class="table-column-title"><a href="<?= Url::toRoute(['forum/view', 'id' => $forum->id])?>"><?= $formatter->asText($forum->name) ?></a></td>
                    <td><?= $formatter->asInteger($forum->number_topics) ?></td>
                    <td><?= $formatter->asInteger($forum->number_posts) ?></td>
                    <td>
                        <?php if ($forum->last_post_created_at): ?>
                        <a href="<?= Url::toRoute(['post/view', 'id' => $forum->last_post_user_id, '#' => 'p' . $forum->last_post_user_id]) ?>"><?= $formatter->asDatetime($forum->last_post_created_at) ?></a> <span class="byuser"><?= $forum->last_post_username ?></span>
                        <?php else: ?>
                        <?= $formatter->asDatetime($forum->last_post_created_at) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; ?>
    <div class="statistic">
        <div class="clearfix">
            <ul class="right">
                <li>Тем: <strong><?= $formatter->asInteger(\app\models\Topic::find()->count()) ?></strong></li>
                <li>Сообщений: <strong><?= $formatter->asInteger(\app\models\Post::find()->count()) ?></strong></li>
            </ul>
            <ul class="left">
                <li>Количество пользователей: <strong><?= $formatter->asInteger(\app\models\User::find()->count()) ?></strong></li>
                <li>Последним зарегистрировался: <a href="">X</a></li>
            </ul>
        </div>
        <div class="onlinelist">
            <span><strong>Сейчас на форуме: </strong> <?= Online::countGuests() ?> гостей, <?= Online::countUsers() ?> пользователей, <?= implode(', ', \yii\helpers\ArrayHelper::getColumn(Online::getActiveUsers(), 'username')) ?></span>
        </div>
    </div>
</div>