<?php

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use app\models\User;
use app\models\search\SearchUsers;
use app\widgets\LinkPager;

/* @var \app\components\View $this */
/* @var ActiveDataProvider $dataProvider */
/* @var array|ActiveRecord[] $users */
/* @var User $user */
/* @var SearchUsers $model */


$this->title = \Yii::t('app/userlist', 'Title');
$this->params['page'] = 'userlist';

$formatter = Yii::$app->formatter;
?>
<div class="blockform">
    <h2><span><?= $this->title ?></span></h2>
    <div class="box">
        <?php $form = ActiveForm::begin([
            'action' => ['user/list'],
            'method' => 'get',
            'options' => ['id' => 'userlist'],
            'enableClientValidation' => false,
            'enableClientScript' => false,
        ]) ?>
        <div class="infldset">
            <fieldset>
                <?= $form->field($model, 'username', [
                    'template' => "{label}\n{input}",
                    'options' => ['class' => 'form-group inline'],
                ])->textInput([
                    'size' => 25,
                    'maxlength' => 25,
                ])->label(\Yii::t('app/userlist', 'Username search')) ?>

                <?= $form->field($model, 'sort_by', [
                    'template' => "{label}\n{input}",
                    'options' => ['class' => 'form-group inline'],
                ])->dropDownList($model->sortItems, [
                ])->label(\Yii::t('app/userlist', 'Sort by search')) ?>

                <?= $form->field($model, 'sort_dir', [
                    'template' => "{label}\n{input}",
                    'options' => ['class' => 'form-group inline'],
                ])->dropDownList([
                    'ASC' => \Yii::t('app/userlist', 'Ascending'),
                    'DESC' => \Yii::t('app/userlist', 'Descending'),
                ], [
                ])->label(\Yii::t('app/userlist', 'Sort order search')) ?>
                <p class="clearb"><?= \Yii::t('app/userlist', 'Info') ?></p>
            </fieldset>
            <p class="buttons"><?= Html::submitButton(\Yii::t('app/userlist', 'Submit')) ?></p>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="linkst">
    <div class="inbox">
        <div class="pagelink">
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
</div>
<div id="users1" class="blocktable">
    <h2><span><?= \Yii::t('app/userlist', 'User list') ?></span></h2>
    <div class="box">
        <div class="inbox">
            <table>
                <thead>
                <tr>
                    <th class="tcl" scope="col"><?= \Yii::t('app/userlist', 'Username') ?></th>
                    <th class="tc2" scope="col"><?= \Yii::t('app/userlist', 'User title') ?></th>
                    <th class="tc3" scope="col"><?= \Yii::t('app/userlist', 'User posts') ?></th>
                    <th class="tcr" scope="col"><?= \Yii::t('app/userlist', 'User registered') ?></th>
                </tr>
                </thead>
                <?php if($users): ?>
                    <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td class="tcl"><a href="<?= Url::to(['user/view', 'id' => $user->id])?>"><?= $formatter->asText($user->username) ?></a></td>
                            <td class="tc2">Пользователь</td>
                            <td class="tc3"><?= $formatter->asInteger($user->number_posts) ?></td>
                            <td class="tcr"><?= $formatter->asDate($user->created_at) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                <?php else: ?>
                    <tbody>
                    <tr>
                        <td colspan="4" class="tcl"><?= \Yii::t('app/userlist', 'No result') ?></td>
                    </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<div class="linkst">
    <div class="inbox">
        <div class="pagelink">
            <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
        </div>
    </div>
</div>
