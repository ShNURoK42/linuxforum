<?php
$this->title = \Yii::t('app/login', 'Login to {title}', ['title' => \Yii::$app->config->get('o_board_title')]);
$this->params['page'] = 'misc';
?>
<div id="rules" class="block">
    <div class="hd"><h2><span><?= \Yii::t('app/common', 'Forum rules') ?></span></h2></div>
    <div class="box">
        <div id="rules-block" class="inbox">
            <div class="usercontent">
                <?= $rules ?>
            </div>
        </div>
    </div>
</div>