<?php


/* @var \app\components\View $this */
/* @var $params $params */

$this->title = $params['name'];
$this->params['page'] = 'info';
?>
<div class="flash">
    <?= $params['message'] ?>
</div>
