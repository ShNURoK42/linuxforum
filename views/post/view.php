<?php
use yii\helpers\Url;
use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use app\models\Post;
use app\models\Topic;
use app\models\forms\PostForm;

/* @var \app\components\View $this */
/* @var Topic $topic */
/* @var Post $post */
/* @var PostForm $model */

$formatter = Yii::$app->formatter;

?>
<div class="post <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="p<?= $post->id ?>">
    <div class="post-avatar">
        <?php if (isset($post->user->email)): ?>
        <?= Gravatar::widget([
            'email' => $post->user->email,
            'options' => [
                'alt' => $post->user->username,
                'class' => 'avatar',
                'width' => 64,
                'height' => 64,
            ],
            'defaultImage' => 'retro',
            'size' => 64
        ]); ?>
        <?php endif; ?>
    </div>
    <div class="post-container">
        <div class="post-content">
            <div class="post-header">
                <span class="post-header-user"><a class="muted-link" href="<?= Url::toRoute(['user/view', 'id' => $post->user_id])?>"><?= (isset($post->user->username)) ? $post->user->username : '' ?></a></span> написал
                <span class="post-header-time"><?= $formatter->asDatetime($post->created_at) ?></span>
                <span class="post-header-count"><a class="muted-link" href="<?= Url::toRoute(['post/view', 'id' => $post->id, '#' => 'p' . $post->id]) ?>">#<?= $count ?></a></span>
                    <?php if (isset($post->user->id) && ($topic->first_post_user_id == $post->user->id)): ?>
                    <span class="post-header-owner">Автор</span>
                    <?php endif; ?>
                    <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
                    <div class="post-header-actions">
                        <a class="post-header-action js-post-update-pencil" href="#"><span class="octicon octicon-pencil octicon-btn"></span></a>
                    </div>
                    <?php endif; ?>
            </div>
            <div class="post-message markdown-body">
                <?= $post->displayMessage ?>
            </div>
            <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
            <div class="post-update">
                <?= Html::textarea('post-update-message', $post->message, ['class' => 'form-control post-update-message']) ?>
                <div class="post-preview postmsg markdown-body"></div>
                <div class="form-actions">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary js-post-update-button']) ?>
                    <?= Html::submitButton('Отменить', ['class' => 'btn btn-danger js-post-cancel-button']) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>



