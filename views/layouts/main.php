<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;
use app\assets\GoogleAsset;
use app\widgets\Menu;
use app\widgets\Welcome;

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
<div id="pun<?= $this->params['page'] ?>" class="pun">
    <div class="punwrap">
        <div id="brdheader" class="block">
            <div class="box">
                <div id="brdtitle" class="inbox">
                    <h1><a href="<?= Url::home() ?>"><?= Yii::$app->config->get('o_board_title') ?></a></h1>
                </div>
                <?php if (Yii::$app->config->get('o_board_desc')): ?>
                <?php endif; ?>
                <?= Menu::widget() ?>
                <?= Welcome::widget() ?>
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

                    </div>
                    <div class="conr">
                        <p id="copyright" style="display: block">
                            <span>&copy;&nbsp;<a href="<?= Url::home() ?>"><?= Yii::$app->config->get('o_board_title') ?></a>,&nbsp;<?= date('Y') ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (Yii::$app->getUser()->getIsGuest()): ?>
    <div class="ads-box" style="overflow: hidden; margin-top: 10px; color: #566579; padding: 0;">
        <div style="float: left">
            <?php require Yii::$app->basePath . '/ads/slibs/csKeysDb.php' ?>
            <?= csKeysDb::getBlock($_SERVER["REQUEST_URI"], 2) ?>
        </div>
        <div style="float: right; border-radius: 10px; color: #566579; border: 1px solid #cad7e1;">
            <ul style="margin: 15px; padding: 0 10px 0 0; line-height: 1; font-size: 11px;">
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
    <?php endif; ?>
</div>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
