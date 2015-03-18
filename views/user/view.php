<?php

/* @var \app\components\View $this */
/* @var \app\models\User $model */

$this->title = $model->username;
$this->params['page'] = 'login';

$formatter = Yii::$app->formatter;
?>
<div id="viewprofile" class="block">
    <h2><span><?= $model->username ?></span></h2>
    <div class="box">
        <div class="fakeform">
            <div class="inform">
                <fieldset>
                    <legend><?= \Yii::t('app/profile', 'Section personal') ?></legend>
                    <div class="infldset">
                        <dl>
                            <dt><?= \Yii::t('app/profile', 'Username') ?></dt><dd><?= $formatter->asText($model->username) ?></dd>
                            <dt><?= \Yii::t('app/profile', 'User title') ?></dt><dd><?= $formatter->asText($model->displayTitle) ?></dd>
                        </dl>
                        <div class="clearer"></div>
                    </div>
                </fieldset>
            </div>
            <div class="inform">
                <fieldset>
                    <legend><?= \Yii::t('app/profile', 'User activity') ?></legend>
                    <div class="infldset">
                        <dl>
                            <dt><?= \Yii::t('app/profile', 'Posts') ?></dt>
                            <?php if ($model->num_posts > 0): ?>
                            <dd><?= $formatter->asInteger($model->num_posts) ?></dd>
                            <?php else: ?>
                            <dd><?= \Yii::t('app/profile', 'No posts') ?></dd>
                            <?php endif; ?>
                            <?php if ($model->last_post): ?>
                            <dt><?= \Yii::t('app/profile', 'Last post') ?></dt>
                            <dd><?= $formatter->asDatetime($model->last_post) ?></dd>
                            <?php endif; ?>
                            <dt><?= \Yii::t('app/profile', 'Registered') ?></dt>
                            <dd><?= $formatter->asDate($model->registered) ?></dd>
                        </dl>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>