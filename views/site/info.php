<?php

use app\models\forms\ForgetForm;

/* @var \app\components\View $this */
/* @var ForgetForm $model */
/* @var $params $params */

$this->title = $params['name'];
$this->params['page'] = 'info';
?>
<div class="callout callout-info">
    <h2><span><?= $this->title ?></span></h2>
    <div class="box">
        <div class="inbox">
            <p><?= $params['message'] ?></p>
        </div>
    </div>
</div>