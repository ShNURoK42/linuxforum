<?php

use yii\helpers\Url;

/** @var \app\models\UserMention[] $userMentions */
/** @var \app\models\UserMention $userMention */
/** @var \app\models\User $user */

?>
<div class="columns">
    <div class="column one-fifth">
        <ul class="filter-list">
            <li>
                <a class="filter-item selected" href="/notifications/participating"><span class="count"><?= count($userMentions) ?></span>Упоминания о вас</a>
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
                    <li class="list-group-item"><a href="<?= Url::toRoute(['post/view', 'id' => $userMention->post_id, '#' => 'p' . $userMention->post_id]) ?>"><strong><?= $userMention->topic->subject ?></strong> #<?= $userMention->post_id ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>