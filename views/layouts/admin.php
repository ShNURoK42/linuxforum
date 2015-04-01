<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;
use app\widgets\Menu;

/**
 * @var \app\components\View $this
 * @var $content string
 */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Url::to('@web/favicon.ico') ?>" />
    <?php if (!$this->title): ?>
        <title><?= Yii::$app->config->get('site_title') ?></title>
    <?php else: ?>
        <title><?= Html::encode($this->title) ?> / <?= Yii::$app->config->get('site_title') ?></title>
    <?php endif; ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="pun<?= $this->params['page'] ?>" class="pun">
    <div class="top-box"></div>
    <div class="punwrap">
        <div id="brdheader" class="block">
            <div class="box">
                <div id="brdtitle" class="inbox">
                    <h1><a href="<?= Url::home() ?>"><?= Yii::$app->config->get('site_title') ?></a></h1>
                </div>
                <div id="brdmenu" class="inbox">
                    <?= Menu::widget() ?>
                </div>
                <div id="brdwelcome" class="inbox">
                    <?php if (\Yii::$app->user->isGuest): ?>
                        <p class="conl"><?= \Yii::t('app/common', 'You are not logged in.') ?></p>
                        <ul class="conr">
                            <li><span>Topics: <a href="search.php?action=show_recent" title="Find topics with recent posts.">Active</a> | <a href="search.php?action=show_unanswered" title="Find topics with no replies.">Unanswered</a></span></li>
                        </ul>
                    <?php else: ?>
                        <ul class="conl">
                            <li><span><?= \Yii::t('app/common', 'Logged in as') ?> <a href="<?= Url::to(['user/profile', 'id' => \Yii::$app->user->identity->id])?>"><strong><?= \Yii::$app->user->identity->username ?></strong></a></span></li>
                        </ul>
                        <ul class="conr">
                            <li><span>Topics: <a href="search.php?action=show_replies" title="Find topics you have posted to.">Posted</a> | <a href="search.php?action=show_new" title="Find topics with new posts since your last visit.">New</a> | <a href="search.php?action=show_recent" title="Find topics with recent posts.">Active</a> | <a href="search.php?action=show_unanswered" title="Find topics with no replies.">Unanswered</a></span></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="brdmain">
            <?= $content ?>
        </div>
        <div id="brdfooter" class="block">
            <h2><span>Board footer</span></h2>
            <div class="box">
                <div id="brdfooternav" class="inbox">
                    <div class="conl">
                        <p id="poweredby" style="display: block">
                            <span style="display: block"><?= \Yii::t('app/common', 'Powered by') ?> <a href="http://linuxforum.ru">SCV System</a></span>
                        </p>
                    </div>
                    <div class="conr">
                        <p id="copyright" style="display: block">
                            <span>&copy;&nbsp;<a href="<?= Url::home() ?>"><?= Yii::$app->config->get('site_title') ?></a>,&nbsp;<?= date('Y') ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="end-box"></div>
</div>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
