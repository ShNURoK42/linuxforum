<?php


use yii\widgets\ListView;
use common\widgets\LinkPager;
use tag\models\Tag;

/**
 * @var \common\components\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array|\yii\db\ActiveRecord[] $topics
 * @var \topic\models\Topic $topic
 * @var \tag\models\Tag $tagModel
 * @var \tag\models\Tag $tag
 */

\topic\TopicAsset::register($this);

$formatter = Yii::$app->formatter;

if ($tagModel instanceof Tag) {
    $this->title = Yii::$app->formatter->asText($tagModel->short_description);
} else {
    $this->title = 'Активные темы';
}

$item['topic_count'] = 0;
?>
<div class="questions-page">
    <div class="nav-panel">
        <div class="nav-panel__title nav-panel__title_text">
            <p>Список вопросов и ответов по ОС linux</p>
        </div>
    </div>

    <div class="search-panel">
        <ul class="search-panel__nav">
            <li class="search-panel__item">
                <div class="dropdown js-dropdown">
                    <a href="#" class="search-panel__link js-dropdown-toggle">Показать</a>
                    <div class="dropdown-menu js-dropdown-menu">
                        <div class="dropdown-menu__header">
                            <span class="dropdown-menu__title">Отфильтровать по:</span>
                            <span class="fa fa-times dropdown-menu__close js-dropdown-menu__close"></span>
                        </div>
                        <ul class="dropdown-menu__list">
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">Дате создания</a>
                            </li>
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">Активности</a>
                            </li>
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">Популярности</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="search-panel__item">
                <div class="dropdown js-dropdown">
                    <a href="#" class="search-panel__link js-dropdown-toggle">Автор</a>
                    <div class="dropdown-menu js-dropdown-menu">
                        <div class="dropdown-menu__header">
                            <span class="dropdown-menu__title">Отфильтровать по автору:</span>
                            <span class="fa fa-times dropdown-menu__close js-dropdown-menu__close"></span>
                        </div>
                        <div class="dropdown-menu__form-group">
                            <input class="form-control dropdown-menu__form-control" name="search" id="search-highlight" type="text">
                        </div>
                        <ul class="list dropdown-menu__list js-dropdown-menu__list">
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">1item 1</a>
                            </li>
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">2item 2</a>
                            </li>
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">3item 3</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="search-panel__item">
                <div class="dropdown js-dropdown">
                    <a href="#" class="search-panel__link js-dropdown-toggle">Сортировать</a>
                    <div class="dropdown-menu js-dropdown-menu">
                        <div class="dropdown-menu__header">
                            <span class="dropdown-menu__title">Отсортировать по:</span>
                            <span class="fa fa-times dropdown-menu__close js-dropdown-menu__close"></span>
                        </div>
                        <ul class="dropdown-menu__list">
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">Убыванию</a>
                            </li>
                            <li class="dropdown-menu__item">
                                <a class="dropdown-menu__link" href="#">Возрастанию</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
        <div class="search-panel__input-box">
            <input class="form-control search-panel__input" type="text" value="1">
        </div>
    </div>


    <div class="question-list">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'postlist js-postlist', 'data-topic-id' => $topic->id, 'data-topic-page' => $dataProvider->pagination->page + 1],
            'layout' => "{items}",
            'itemOptions' => ['tag' => false],
            'itemView' => function ($model, $key, $index, $widget) use ($dataProvider) {
                return $this->render('_list_question_row.php', [
                    'model' => $model,
                    'key' => $key,
                    'index' => $index,
                    'widget' => $widget,
                ]);
            },
        ]) ?>
    </div>
    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
</div>