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
    <title><?= Yii::$app->config->get('o_board_title') ?></title>
    <?php else: ?>
    <title><?= Html::encode($this->title) ?> / <?= Yii::$app->config->get('o_board_title') ?></title>
    <?php endif; ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="header">
    <div class="container">
        <div class="navbar-brand">
            <? if (Yii::$app->controller->route == 'site/index'): ?>
                <span><?= Yii::$app->config->get('o_board_title') ?></span>
            <? else: ?>
                <a href="<?= Yii::$app->urlManager->createUrl('site/index') ?>"><?= Yii::$app->config->get('o_board_title') ?></a>
            <? endif; ?>
        </div>
        <?= Navigation::widget(['position' => 'header']); ?>
    </div>
</header>
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
            <h6>&copy;&nbsp;<?= Yii::$app->config->get('o_board_title') ?>,&nbsp;<?= date('Y') ?></h6>
        </div>
        <div class="footbar">
            <?= Navigation::widget(['position' => 'footer']); ?>
        </div>
    </div>
</footer>



<?php if (Yii::$app->getUser()->getIsGuest()): ?>
<div class="container">
    <div class="ads-box clearfix" style="margin: 10px 0 30px; color: #566579; padding: 0;">
        <div class="pull-left">
            <?php require Yii::$app->basePath . '/ads/slibs/csKeysDb.php' ?>
            <?= csKeysDb::getBlock($_SERVER["REQUEST_URI"], 2) ?>
        </div>
        <div class="pull-right" style="border-radius: 10px; color: #566579; border: 1px solid #cad7e1;">
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
<div class="container">
<?php endif; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
