<?php

use yii\db\ActiveRecord;
use yii\helpers\Url;
use app\models\Category;
use app\models\Forum;
use app\models\Online;

/**
 * @var \app\components\View $this
 * @var ActiveRecord[] $categories
 * @var Category $category
 * @var Forum $forum
 */

$this->params['page'] = 'index';
$item = [
    'forum_count' => 0,
    'category_count' => 0,
];

$formatter = Yii::$app->formatter;
?>
<?php if (count($categories) == 0): ?>
<div id="idx0" class="block">
    <div class="box">
        <div class="inbox"><p><?= Yii::t('app/index', 'Empty board') ?></p></div>
    </div>
</div>
<?php else: ?>
<?php foreach($categories as $category): ?>
<?php $item['category_count']++ ?>
<div id="idx<?= $item['category_count'] ?>" class="blocktable">
    <h2><span><?= $formatter->asText($category->cat_name) ?></span></h2>
    <div class="box">
        <div class="inbox">
            <table>
                <thead>
                    <tr>
                        <th class="tcl" scope="col"><?= Yii::t('app/index', 'Forum') ?></th>
                        <th class="tc2" scope="col"><?= Yii::t('app/index', 'Topics') ?></th>
                        <th class="tc3" scope="col"><?= Yii::t('app/index', 'Posts') ?></th>
                        <th class="tcr" scope="col"><?= Yii::t('app/index', 'Last post') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($category->forums as $forum): ?>
                    <?php $item['forum_count']++ ?>
                    <tr class="<?= ($item['forum_count'] % 2 == 0) ? 'roweven' : 'rowodd' ?>">
                        <td class="tcl">
                            <div class="icon"><div class="nosize">1</div></div>
                            <div class="tclcon">
                                <div>
                                    <h3><a href="<?= Url::toRoute(['forum/view', 'id' => $forum->id])?>"><?= $formatter->asText($forum->forum_name) ?></a></h3>
                                    <?php if ($forum->forum_desc): ?>
                                    <div class="forumdesc"><?= $formatter->asText($forum->forum_desc) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="tc2"><?= $formatter->asInteger($forum->num_topics) ?></td>
                        <td class="tc3"><?= $formatter->asInteger($forum->num_posts) ?></td>
                        <td class="tcr">
                            <?php if ($forum->last_post): ?>
                            <a href="<?= Url::toRoute(['post/view', 'id' => $forum->last_post_id, '#' => 'p' . $forum->last_post_id]) ?>"><?= $formatter->asDatetime($forum->last_post) ?></a> <span class="byuser"><?= $forum->last_poster ?></span>
                            <?php else: ?>
                            <?= $formatter->asDatetime($forum->last_post) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="block" id="brdstats">
    <div class="box">
        <div class="inbox">
            <dl class="conr">
                <dd><span>Тем: <strong><?= $formatter->asInteger(\app\models\Topic::find()->count()) ?></strong></span></dd>
                <dd><span>Сообщений: <strong><?= $formatter->asInteger(\app\models\Post::find()->count()) ?></strong></span></dd>
            </dl>
            <dl class="conl">
                <dd><span>Количество пользователей: <strong><?= $formatter->asInteger(\app\models\User::find()->count()) ?></strong></span></dd>
                <dd style="display: none"><span>Последним зарегистрировался: <a href="profile.php?id=60868">JessieMTran</a></span></dd>
            </dl>
            <dl class="clearb" id="onlinelist">
                <dt><strong>Сейчас на форуме: </strong></dt>
                <dd><?= Online::countGuests() ?> гостей,</dd>
                <dd><?= Online::countUsers() ?> пользователей,</dd>
                <dd><?= implode(', ', \yii\helpers\ArrayHelper::getColumn(Online::getActiveUsers(), 'username')) ?></dd>
            </dl>
        </div>
    </div>
</div>
