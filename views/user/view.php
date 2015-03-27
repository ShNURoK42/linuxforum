<?php
use cebe\gravatar\Gravatar;

/* @var \app\components\View $this */
/* @var \app\models\User $user */

$this->title = $user->username;
$this->params['page'] = 'login';

$formatter = Yii::$app->formatter;
?>
<div class="page-profile">
    <?php echo Gravatar::widget([
        'email' => $user->email,
        'options' => [
            'alt' => $user->username,
            'class' => 'avatar',
            'width' => 150,
            'height' => 150,
        ],
        'defaultImage' => 'retro',
        'size' => 150
    ]); ?>
    <div class="profile-box">
        <h2>about</h2>
        <?php if ($user->about): ?>
        <?= $user->displayAbout ?>
        <?php else: ?>
        <p>Пользователь не оставил информации о себе.</p>
        <?php endif; ?>
    </div>
    <div class="profile-box">
        <h2>information</h2>
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
    <div class="profile-box">
        <h2>contact</h2>
        <p>Почта.</p>
    </div>
</div>


<div style="overflow: hidden; background-color: #f5f5f5;">
    <div style="width: 25%;float: left;">column 1 dfgdfgdfgdfgdf
        <?php echo Gravatar::widget([
            'email' => $user->email,
            'options' => [
                'alt' => $user->username,
                'class' => 'avatar',
                'width' => 150,
                'height' => 150,
            ],
            'defaultImage' => 'retro',
            'size' => 150
        ]); ?>
    </div>
    <div style="width: 75%;float: right;">column 2</div>
</div>
