<?php
/* @var string $title */
/* @var string $subtitle */
/* @var array $options */
?>
<div class="<?= $options['class'] ?>">
    <div class="container">
        <h2><?= $title ?></h2>
        <? if (isset($subtitle)): ?>
        <p><?= $subtitle ?></p>
        <? endif; ?>
    </div>
</div>
