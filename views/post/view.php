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
<div class="blockpost <?= ($count % 2 == 0) ? 'roweven' : 'rowodd' ?><?= ($count == 1) ? ' firstpost' : '' ?>" id="p<?= $post->id ?>">
    <h2><span><span class="conr"><?= ($topic->first_post_user_id == $post->user->id) ? '<span class="post-author-label">Автор темы</span>' : '' ?> <a href="<?= Url::toRoute(['post/view', 'id' => $post->id, '#' => 'p' . $post->id]) ?>">#<?= $count ?></a></span><?= $formatter->asDatetime($post->created_at) ?></span></h2>
    <div class="box">
        <div class="inbox">
            <div class="postbody">
                <div class="postleft">
                    <dl>
                        <dt><strong><a href="<?= Url::toRoute(['user/view', 'id' => $post->user_id])?>"><?= $post->user->username ?></a></strong></dt>
                        <dd class="usertitle"></dd>
                        <dd class="postavatar"><?php echo Gravatar::widget([
                                'email' => $post->user->email,
                                'options' => [
                                    'alt' => $post->user->username,
                                ],
                                'defaultImage' => 'retro',
                                'size' => 92
                            ]); ?></dd>
                        <dd><span><strong>Сообщений:</strong> <?= Yii::$app->formatter->asInteger($post->user->number_posts) ?></span></dd>
                        <p></p>
                        <dd><span><strong>Зарегистрирован:</strong> <?= $formatter->asDate($post->user->created_at) ?></span></dd>
                    </dl>
                </div>
                <div class="postright">
                    <h3><?= $formatter->asText($topic->subject) ?></h3>
                    <div class="postmsg"><?= $post->displayMessage ?></div>
                </div>
            </div>
        </div>
    </div>
</div>