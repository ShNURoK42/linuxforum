<?php
use cebe\gravatar\Gravatar;

/* @var \app\components\View $this */
/* @var \app\models\User $user */

$this->title = $user->username;
$this->params['page'] = 'login';

$formatter = Yii::$app->formatter;
?>
<div id="viewprofile" class="block">
    <h2><span><?= $user->username ?></span></h2>
    <div class="infldset">
        <dl>
            <dt><?php echo Gravatar::widget([
                    'email' => $user->email,
                    'options' => [
                        'alt' => $user->username,
                    ],
                    'defaultImage' => 'retro',
                    'size' => 150
                ]); ?></dt>
            <dd style="min-height: 152px">
                <?php if ($user->about): ?>
                <div class="postsignature postmsg" style="min-height: 30px"><?= $user->displayAbout ?></div>
                <?php else: ?>
                <div class="postsignature postmsg" style="min-height: 30px">Пользователь не оставил информации о себе</div>
                <?php endif; ?>
                <dl>
                    <dt>Статус</dt>
                    <dd>Пользователь</dd>
                    <dt><?= \Yii::t('app/profile', 'Posts') ?></dt>
                    <?php if ($user->number_posts > 0): ?>
                        <dd><?= $formatter->asInteger($user->number_posts) ?></dd>
                    <?php else: ?>
                        <dd><?= \Yii::t('app/profile', 'No posts') ?></dd>
                    <?php endif; ?>
                    <dt><?= \Yii::t('app/profile', 'Registered') ?></dt>
                    <dd><?= $formatter->asDate($user->created_at) ?></dd>
                    <?php if ($user->last_posted_at): ?>
                        <dt><?= \Yii::t('app/profile', 'Last post') ?></dt>
                        <dd><?= $formatter->asDatetime($user->last_posted_at) ?></dd>
                    <?php endif; ?>
                </dl>
            </dd>
        </dl>
        <div class="clearer"></div>
    </div>
</div>