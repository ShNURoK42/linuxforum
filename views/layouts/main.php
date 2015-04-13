<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\MainAsset;
use app\widgets\Navigation;
use app\widgets\PageHead;

/**
 * @var \app\components\View $this
 * @var $content string
 */

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($this->description): ?>
    <meta name="description" content="<?= $this->description ?>">
    <?php endif; ?>
    <?php if ($this->keywords): ?>
    <meta name="keywords" content="<?= $this->keywords ?>">
    <?php endif; ?>
    <?php if ($this->author): ?>
    <meta name="author" content="<?= $this->author ?>">
    <?php endif; ?>
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
<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <?php if (Yii::$app->controller->route == 'site/index'): ?>
                <span><?= Yii::$app->config->get('site_title') ?></span>
                <span class="navbar-brand-beta tooltipped tooltipped-s" aria-label="Сайт находится на стадии разработки"><a href="<?= Url::toRoute(['forum/view', 'id' => 3]) ?>">alpha</a></span>
            <?php else: ?>
                <a href="<?= Yii::$app->urlManager->createUrl('site/index') ?>"><?= Yii::$app->config->get('site_title') ?></a>
                <span class="navbar-brand-beta tooltipped tooltipped-s" aria-label="Сайт находится на стадии разработки"><a href="<?= Url::toRoute(['forum/view', 'id' => 3]) ?>">alpha</a></span>
            <?php endif; ?>
        </div>
        <?= Navigation::widget(['position' => 'header']); ?>
    </div>
</nav>
<div class="search-links">
    <div class="container">
        <ul class="search-links-list right">
            <div class="btn-group">
                <?php if (!Yii::$app->getUser()->getIsGuest()):?>
                <a class="btn btn-sm btn-outline" title="Темы в которых вы отвечали." href="/search/ownpost_topics">Ваши темы</a>
                <?php endif; ?>
                <a class="btn btn-sm btn-outline" title="Темы с активностью в последние 24 часа." href="/search/active_topics">Активные темы</a>
                <a class="btn btn-sm btn-outline" title="Темы без ответов." href="/search/unanswered_topics">Темы без ответов</a>
            </div>
        </ul>
    </div>
</div>
<section class="content">
    <?= PageHead::widget(['title' => $this->title, 'subtitle' => $this->subtitle]) ?>
    <div class="pagecontent">
        <div class="container">
            <?= $content; ?>
        </div>
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
<?php if (Yii::$app->getUser()->getIsGuest()): ?>
<div class="container">
    <div class="ads-box clearfix" style="margin: 10px 0 30px; color: #566579; padding: 0;">
        <div class="left">
            <?php require Yii::$app->basePath . '/ads/slibs/csKeysDb.php' ?>
            <?= csKeysDb::getBlock($_SERVER["REQUEST_URI"], 2) ?>
        </div>
        <div class="right" style="border-radius: 10px; color: #566579; border: 1px solid #cad7e1;">
            <ul style="margin: 10px; padding: 0; line-height: 1; font-size: 11px; list-style: outside none none;">
                <?php if (Yii::$app->controller->route == 'site/index'): ?>
                <li><a href=http://www.zapravkairemont.ru>заправка картриджей hp</a></li>
                <li>Профессиональная <a href=http://pchlp.ru/>компьютерная помощь на дому</a> в Москве</li>
                <li><a href=http://www.bergab.ru>подшипники</a> для пользователей linux</li>
                <li>Недорогие <a href=http://www.saletur.ru>горящие туры</a> на сайте SaleTur.ru</li>
                <?php else: ?>
                <li>Продаем <a href=http://www.realxenon.ru/modules/shop/cat_188.html>камеры заднего вида</a> на все марки автомобилей</li>
                <li><a href=http://www.bergab.ru>Подшипники</a> для пользователей linux</li>
                <li>Купить <a href=http://elitpack.ru/>полиэтиленовые пакеты</a> с логотипом, производство пакетов</li>
                <li>Мегаполис <a href=http://www.megapolistaxi.ru/>такси москва</a> - заказ такси дешево и быстро!</li>
                <li>Недорогие <a href=http://www.saletur.ru>горящие туры</a> на сайте SaleTur.ru </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
