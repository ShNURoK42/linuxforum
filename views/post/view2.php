<?php
use yii\helpers\Url;
use cebe\gravatar\Gravatar;
use yii\helpers\Html;
use app\models\Post;
use app\models\Topic;
use app\models\forms\PostForm;
use app\widgets\ActiveForm;

/* @var \app\components\View $this */
/* @var Topic $topic */
/* @var Post $post */
/* @var PostForm $model */

$model = new PostForm();
$model->message = $post->message;

$formatter = Yii::$app->formatter;

?>
<div class="post <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="p<?= $post->id ?>">
    <div class="post-body">
        <div class="post-user">
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
                        'width' => 64,
                        'height' => 64,
                    ],
                    'defaultImage' => 'retro',
                    'size' => 64
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
        <div class="post-content">
            <div class="post-header">
                <span class="post-header-user"><?= $formatter->asText($post->user->username) ?></span>
                <span class="post-header-time"><?= $formatter->asDatetime($post->created_at) ?></span>
                <span class="post-header-count"><a href="<?= Url::toRoute(['post/view', 'id' => $post->id, '#' => 'p' . $post->id]) ?>">#<?= $count ?></a></span>
                    <?php if ($topic->first_post_user_id == $post->user->id): ?>
                    <span class="post-header-owner">Автор</span>
                    <?php endif; ?>
                    <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
                    <div class="post-header-actions">
                        <a class="post-header-action js-post-edit-button" href="#"><span class="octicon octicon-pencil octicon-btn"></span></a>
                    </div>
                    <?php endif; ?>
            </div>
            <div class="post-message markdown-body">
                <?= $post->displayMessage ?>
            </div>
        </div>
    </div>
</div>











        <?php if (Yii::$app->getUser()->can('updatePost', ['post' => $post])): ?>
        <div class="post-right-update">
            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'message', [
                'template' => "{input}",
                'options' => [
                    'class' => 'update-post-message'
                ],
            ])->textarea() ?>
            <div class="post-preview postmsg markdown-body"></div>
            <div class="form-actions">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
        <?php endif; ?>



