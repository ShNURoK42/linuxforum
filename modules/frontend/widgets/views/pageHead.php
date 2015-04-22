<?php
/* @var string $title */
/* @var string $subtitle */
/* @var array $options */

$formatter = Yii::$app->formatter;
?>
<div class="<?= $options['class'] ?>">
    <div class="container">
        <h1><?= $formatter->asText($title) ?></h1>
        <?php if (isset($subtitle)): ?>
        <p><?= $subtitle ?></p>
        <?php endif; ?>
    </div>
</div>
