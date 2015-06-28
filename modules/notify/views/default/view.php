<?php

use yii\helpers\Url;

/** @var \notify\models\UserMention[] $userMentions */
/** @var \notify\models\UserMention $userMention */
/** @var \user\models\User $user */

?>
<div class="columns">
    <div class="column one-fifth">
        <ul class="filter-list">
            <li>
                <a class="filter-item selected" href=""><span class="count"><?= count($userMentions) ?></span>Упоминания вас</a>
            </li>
        </ul>
    </div>

    <div class="column four-fifths">
        <?php if (!$userMentions): ?>
        <div class="blankslate spacious large-format">
            <h3>Нет новых уведомлений.</h3>
        </div>
        <?php else: ?>
        <div class="notifications-list">
            <div class="boxed-group">
                <h3>Вас упоминули в теме:</h3>
                <ul class="boxed-group-inner list-group notifications">
                    <?php foreach($userMentions as $userMention): ?>
                    <li class="list-group-item">
                        <a href="<?= Url::toRoute(['/topic/default/view', 'id' => $userMention->topic_id]) ?>"><strong><?= $userMention->topic->subject ?></strong></a> <a href="<?= Url::toRoute(['/post/default/view', 'id' => $userMention->post_id, '#' => 'post' . $userMention->post_id]) ?>">#<?= $userMention->post_id ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>