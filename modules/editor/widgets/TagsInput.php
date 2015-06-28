<?php
namespace editor\widgets;

use Yii;
use yii\helpers\Html;
use editor\TagsInputAsset;

class TagsInput extends \yii\widgets\InputWidget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $view = $this->getView();
        TagsInputAsset::register($view);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options['placeholder'] = 'Добавьте метку';
        echo Html::activeTextInput($this->model, $this->attribute, $options);
    }
}