<?php
use yii\helpers\Url;
use cebe\gravatar\Gravatar;
use app\models\Post;
use app\models\Topic;

/* @var \app\components\View $this */
/* @var Topic $topic */
/* @var Post $post */

$formatter = Yii::$app->formatter;
?>
<div class="page-view-post">
    <div class="post-box <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="p<?= $post->id ?>">
        <div class="inbox">
            <div class="post-body">
                <div class="post-left">
                    <?php if ($post->user->username): ?>
                    <div class="post-username"><a href="<?= Url::toRoute(['user/view', 'id' => $post->user_id])?>"><?= $post->user->username ?></a></div>
                    <?php else: ?>
                    <div class="post-username">Автор неизвестен</div>
                    <?php endif; ?>
                    <div class="post-avatar">
                        <?php if ($post->user->email): ?>
                        <?php echo Gravatar::widget([
                            'email' => $post->user->email,
                            'options' => [
                                'alt' => $post->user->username,
                                'class' => 'avatar',
                                'width' => 92,
                                'height' => 92,
                            ],
                            'defaultImage' => 'retro',
                            'size' => 92
                        ]); ?>
                        <?php endif; ?>
                    </div>
                    <?php if ($post->user->number_posts): ?>
                    <div class="post-number-posts"><strong>Сообщений:</strong> <?= Yii::$app->formatter->asInteger($post->user->number_posts) ?></div>
                    <?php endif; ?>
                    <?php if ($post->user->created_at): ?>
                    <div class="post-registered"><span><strong>Зарегистрирован:</strong> <?= $formatter->asDate($post->user->created_at) ?></div>
                    <?php endif; ?>
                </div>
                <div class="post-right-header">
                    <span class="post-header-time"><?= $formatter->asDatetime($post->created_at) ?></span>
                    <span class="post-header-count"><a href="<?= Url::toRoute(['post/view', 'id' => $post->id, '#' => 'p' . $post->id]) ?>">#<?= $count ?></a></span>
                    <?php if ($topic->first_post_user_id == $post->user->id): ?>
                    <span class="post-header-owner">Автор</span>
                    <?php endif; ?>
                    <?php if (Yii::$app->getUser()->getIdentity()->getId() == $post->user->id): ?>
                    <a class="post-header-edit" href="#"><span class="octicon octicon-pencil octicon-btn"></span></a>
                    <?php endif; ?>
                </div>
                <div class="post-right">
                    <div class="post-message markdown-body">
                        <?= $post->displayMessage ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
