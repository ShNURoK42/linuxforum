<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\GoogleAsset;
use ad\Ad;
use frontend\FrontendAsset;
use frontend\widgets\Navigation;

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
        <div class="navbar-brand">
            <?php if (Yii::$app->controller->route == 'site/index'): ?>
            <span><?= Yii::$app->config->get('site_title') ?></span><span class="navbar-brand-beta tooltipped tooltipped-s" aria-label="Сайт находится на стадии разработки"><a href="<?= Url::toRoute(['/forum/default/view', 'id' => 3]) ?>">alpha</a></span>
            <?php else: ?>
            <a href="<?= Url::home() ?>"><?= Yii::$app->config->get('site_title') ?></a><span class="navbar-brand-beta"><a href="<?= Url::toRoute(['/topic/default/list', 'name' => 'support']) ?>"><sup>beta</sup></a></span>
            <?php endif; ?>
        </div>
        <?= Navigation::widget(['position' => 'header']); ?>
    </div>
</nav>
<div class="sub-navbar">
    <div class="container">
        <?= Navigation::widget(['position' => 'sub_header']); ?>
    </div>
</div>
<section class="content">
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
<?= Ad::widget() ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
