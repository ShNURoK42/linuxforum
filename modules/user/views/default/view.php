<?php
use cebe\gravatar\Gravatar;
use yii\helpers\Url;

/* @var \app\components\View $this */
/* @var \user\models\User $user */

$this->title = $user->username;
$this->params['page'] = 'login';

$formatter = Yii::$app->formatter;
?>
<div class="page-profile">
    <div class="vcard">
        <div class="profile-avatar">
        <?php echo Gravatar::widget([
            'email' => $user->email,
            'options' => [
                'alt' => $user->username,
                'class' => 'avatar',
                'width' => 250,
                'height' => 250,
            ],
            'defaultImage' => 'retro',
            'size' => 250
        ]); ?>
        </div>
        <?php if (Yii::$app->getUser()->can('updateProfile', ['user' => $user])): ?>
            <?php if (Yii::$app->getUser()->getIdentity()->getId() == $user->id): ?>
            <a class="btn profile-edit-btn" href="<?= Url::toRoute(['/user/settings/profile']) ?>"><span class="octicon octicon-pencil"></span> Редактировать профиль</a>
            <?php else: ?>
            <a class="btn profile-edit-btn" href="<?= Url::toRoute(['/user/settings/profile', 'id' => $user->id]) ?>"><span class="octicon octicon-pencil"></span> Редактировать профиль</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="profile-info">
        <div class="profile-info-box">
            <h2>about</h2>
            <?php if ($user->about): ?>
                <?= $user->displayAbout ?>
            <?php else: ?>
                <p>Пользователь не оставил информации о себе.</p>
            <?php endif; ?>
        </div>
        <div class="profile-info-box">
            <h2>info</h2>
            <p><strong>Статус:</strong> Пользователь</p>
            <p><strong>Количество сообщений:</strong>
                <?php if ($user->number_posts > 0): ?>
                    <?= $formatter->asInteger($user->number_posts) ?>
                <?php else: ?>
                    <?= \Yii::t('app/profile', 'No posts') ?>
                <?php endif; ?></p>
            <p><strong>Дата регистрации:</strong> <?= $formatter->asDate($user->created_at) ?></p>
            <?php if ($user->last_posted_at): ?>
                <p><strong>Последнее сообщение:</strong> <?= $formatter->asDatetime($user->last_posted_at) ?></p>
            <?php endif; ?>
        </div>
        <div class="profile-info-box">
            <h2>contact</h2>
            <p>Почта.</p>
        </div>
    </div>
</div>
