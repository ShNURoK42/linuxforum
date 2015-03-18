<?php
use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;
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
</div>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
