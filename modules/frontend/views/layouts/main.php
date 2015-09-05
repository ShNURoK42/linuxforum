<?php
use yii\helpers\Html;
use yii\helpers\Url;
use ad\Ad;
use frontend\assets\GoogleAsset;
use frontend\assets\FrontendAsset;
use frontend\widgets\Navigation;
use sidebar\Sidebar;

/**
 * @var \common\components\View $this
 * @var $content string
 */

FrontendAsset::register($this);
if (!YII_DEBUG) {
    GoogleAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php if (YII_ENV == 'test'): ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <?php else: ?>
        <meta charset="<?= Yii::$app->charset ?>">
    <?php endif ?>
<?php if ($this->description): ?>
    <meta name="description" content="<?= $this->description ?>">
<?php endif; ?>
<?php if ($this->keywords): ?>
    <meta name="keywords" content="<?= $this->keywords ?>">
<?php endif; ?>
<?php if ($this->author): ?>
    <meta name="author" content="<?= $this->author ?>">
<?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
<?php if (!$this->title): ?>
<title><?= Yii::$app->config->get('site_title') ?></title>
<?php else: ?>
<title><?= Html::encode($this->title) ?> / <?= Yii::$app->config->get('site_title') ?></title>
<?php endif; ?>
<link rel="shortcut icon" href="<?= Url::to('@web/favicon.ico') ?>" />
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="b-navbar">
    <div class="l-container">
        <a class="b-navbar__brand" href="/">linuxforum</a><span class="b-navbar__brand-beta">beta</span>
        <ul class="m-navbar__menu b-menu">
            <li class="b-menu__item b-menu__item_active">
                <a class="b-menu__link b-menu__link-active" href="/registration"><i class="fa fa-bell"></i> Уведомления <span class="b-label b-label-warning b-menu__link-active-label">10</span></a>
            </li>
            <li class="b-menu__item">
                <a class="b-menu__link" href="/registration"><i class="fa fa-wrench"></i> Настройки</a>
            </li>
            <li class="b-menu__item">
                <a class="b-menu__link" href="/registration"><i class="fa fa-question-circle"></i> Помощь</a>
            </li>
            <li class="b-menu__item">
                <a class="b-menu__link" href="/registration"><i class="fa fa-sign-out"></i> Выход</a>
            </li>
        </ul>
    </div>
</nav>
<nav class="b-sub-navbar">
    <div class="l-container">
        <ul class="m-sub-navbar__menu b-menu">
            <li class="b-menu__item">
                <div class="b-input-group">
                    <input type="text" class="b-form-control" placeholder="Поиск по сайту">
                </div>
            </li>
            <li class="b-menu__item">
                <a class="b-btn b-btn-primary b-menu__btn" href="/user/default/list" title="Вопросы и ответы по ОС linux">questions</a>
            </li>
            <li class="b-menu__item">
                <a class="b-btn b-btn-primary b-menu__btn" href="/topic/default/list4" title="Обсуждение различных тем">forum</a>
            </li>
            <li class="b-menu__item">
                <a class="b-btn b-btn-primary b-menu__btn b-menu__btn_active" href="/user/default/list" title="Список полльзователей сайта">users</a>
            </li>
        </ul>
    </div>
</nav>




<section class="content">
    <div class="l-container">
        <div class="page-content">
            <?= $content; ?>
        </div>
        <?= Sidebar::widget() ?>
    </div>
</section>
<footer class="footer">
    <div class="container">
        <div class="copyright">
            <h6>&copy;&nbsp;<?= Yii::$app->config->get('site_title') ?>,&nbsp;<?= date('Y') ?></h6>
        </div>
        <div class="footbar">
            <?= Navigation::widget(['position' => 'footer']); ?>
        </div>
    </div>
</footer>
<?= Ad::widget() ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
