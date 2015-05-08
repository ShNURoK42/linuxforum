<?php
use yii\helpers\Url;
use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use post\models\Post;
use topic\models\Topic;

/* @var \app\components\View $this */
/* @var Topic $topic */
/* @var Post $model */

$formatter = Yii::$app->formatter;

?>
<div class="post <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="p<?= $model->id ?>">
    <div class="post-avatar">
        <?php if (isset($model->user->email)): ?>
        <?= Gravatar::widget([
            'email' => $model->user->email,
            'options' => [
                'alt' => $model->user->username,
                'class' => 'avatar',
                'width' => 48,
                'height' => 48,
            ],
            'defaultImage' => 'retro',
            'size' => 48
        ]); ?>
        <?php endif; ?>
    </div>
    <div class="post-container">
        <div class="post-content">
            <div class="post-header">
                <span class="post-header-user"><a class="muted-link" href="<?= Url::toRoute(['/user/default/view', 'id' => $model->user_id])?>"><?= (isset($model->user->username)) ? $model->user->username : '' ?></a></span> написал
                <span class="post-header-time"><?= $formatter->asDatetime($model->created_at) ?></span>
                <span class="post-header-count"><a class="muted-link" href="<?= Url::toRoute(['/topic/post/view', 'id' => $model->id, '#' => 'p' . $model->id]) ?>">#<?= $count ?></a></span>
                    <?php if ($model->isTopicAuthor): ?>
                    <span class="post-header-owner">Автор</span>
                    <?php endif; ?>
                    <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $model])): ?>
                    <div class="post-header-actions">
                        <a class="post-header-action js-post-update-pencil" href="#"><span class="fa fa-pencil"></span></a>
                    </div>
                    <?php endif; ?>
            </div>
            <div class="post-message markdown-body">
                <?= $model->displayMessage ?>
            </div>
            <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $model])): ?>
            <div class="post-update">
                <?= Html::textarea('post-update-message', $model->message, ['class' => 'form-control post-update-message']) ?>
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
