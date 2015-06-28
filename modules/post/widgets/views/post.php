<?php

/* @var \common\components\View $this */
/* @var \post\models\Post $post */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use cebe\gravatar\Gravatar;

$formatter = Yii::$app->formatter;
?>
<div class="post js-post <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="post<?= $post->id ?>" data-post-id="<?= $post->id ?>">
    <div class="post-avatar">
        <?php if (isset($post->user->email)): ?>
        <?= Gravatar::widget([
            'email' => $post->user->email,
            'options' => [
                'alt' => $post->user->username,
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
                <span class="post-header-user"><a class="muted-link" href="<?= Url::toRoute(['/user/default/view', 'id' => $post->user_id])?>"><?= (isset($post->user->username)) ? $post->user->username : '' ?></a></span> написал
                <span class="post-header-time"><?= $formatter->asDatetime($post->created_at) ?></span>
                <span class="post-header-count"><a class="muted-link" href="<?= Url::toRoute(['/post/default/view', 'id' => $post->id, '#' => 'post' . $post->id]) ?>">#<?= $count ?></a></span>
                    <?php if ($post->isTopicAuthor): ?>
                    <span class="post-header-owner">Автор</span>
                    <?php endif; ?>
                    <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
                    <div class="post-header-actions">
                        <a class="post-header-action js-post-update-button" href="#"><span class="fa fa-pencil"></span></a>
                        <a class="post-header-action js-post-delete-button" href="#"><span class="fa fa-times"></span></a>
                    </div>
                    <?php endif; ?>
            </div>
            <div class="post-body">
                <div class="post-message markdown-body js-post-message">
                    <?= $post->displayMessage ?>
                </div>
                <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
                <div class="post-update-formbox js-post-update">
                    <?php $form = ActiveForm::begin([
                        'enableClientScript' => false,
                    ]) ?>
                    <?= $form->errorSummary($model, [
                        'class' => 'form-group',
                        'header' => '',
                    ]) ?>
                    <?= $form->field($model, 'message', [
                        'template' => "{input}",
                    ])->widget('\editor\widgets\Textarea', [
                        'isShowButtons' => false,
                        'options' => ['class' => 'post-update-message']
                    ]) ?>
                    <div class="form-group form-actions">
                        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary js-post-update-submit']) ?>
                        <?= Html::submitButton('Отменить', ['class' => 'btn btn-danger js-post-cancel-submit']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
