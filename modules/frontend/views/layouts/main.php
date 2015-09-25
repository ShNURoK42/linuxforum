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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<?php if ($this->description): ?>
    <meta name="description" content="<?= $this->description ?>">
<?php endif; ?>
<?php if ($this->keywords): ?>
    <meta name="keywords" content="<?= $this->keywords ?>">
<?php endif; ?>
<?php if ($this->author): ?>
    <meta name="author" content="<?= $this->author ?>">
<?php endif; ?>
    <meta name="viewport" content="width=device-width, initiascale=1">
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
<nav class="navbar">
    <div class="container">
        <a class="navbar__brand navbar__brand-current" href="/">linuxforum</a><span class="navbar__brand-beta">beta</span>
        <ul class="navbar__nav nav">
            <li class="nav__item nav__item_active">
                <a class="nav__link nav__link-active" href="/registration"><i class="fa fa-bell"></i> Уведомления <span class="label label-warning nav__link-active-label" title="У вас 10 непросмотренных уведомлений">10</span></a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="/registration"><i class="fa fa-wrench"></i> Настройки</a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="/registration"><i class="fa fa-question-circle"></i> Помощь</a>
            </li>
            <li class="nav__item">
                <a class="nav__link" href="/registration"><i class="fa fa-sign-out"></i> Выход</a>
            </li>
        </ul>
    </div>
</nav>
<nav class="subnavbar">
    <div class="container">
        <div class="site-search">
            <input type="text" class="form-control site-search__input js-site-search__input">
            <i class="fa fa-search site-search__icon"></i>
        </div>
        <ul class="subnavbar__nav nav">
            <li class="nav__item">
                <a class="btn nav__pill" href="/user/default/list" title="Вопросы и ответы по ОС linux">новости</a>
            </li>
            <li class="nav__item">
                <a class="btn nav__pill" href="/user/default/list" title="Вопросы и ответы по ОС linux">блог</a>
            </li>
            <li class="nav__item">
                <a class="btn nav__pill" href="/user/default/list" title="Вопросы и ответы по ОС linux">страницы</a>
            </li>
            <li class="nav__item">
                <a class="btn nav__pill" href="/user/default/list" title="Вопросы и ответы по ОС linux">вопросы</a>
            </li>
            <li class="nav__item">
                <a class="btn nav__pill" href="/topic/default/list4" title="Обсуждение различных тем">форум</a>
            </li>
            <li class="nav__item">
                <a class="btn nav__pill nav__pill_active" href="/user/default/list" title="Список полльзователей сайта">пользователи</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="site-message site-message__text">
        <h5>Добро пожаловать на linuxforum!</h5>
        <p>Русскоязычный ресурс, посвященный операционной системе linux и свободному программному обеспечению!</p>
    </div>
</div>



<section class="content">
    <div class="container">
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
