<?php
namespace editor\widgets;

use Yii;
use editor\TextareaAsset;
use editor\ButtonsAsset;
use yii\helpers\Html;

class Textarea extends \yii\widgets\InputWidget
{
    /**
     * @var boolean
     */
    public $isShowButtons = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $view = $this->getView();
        if ($this->isShowButtons) {
            ButtonsAsset::register($view);
        } else {
            TextareaAsset::register($view);
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $options = $this->options;
        Html::addCssClass($options, 'js-editor-textarea');
        if ($this->isShowButtons) {
            echo $this->render('buttons');
        }
        $options['placeholder'] = 'Напишите сообщение';
        echo Html::activeTextarea($this->model, $this->attribute, $options);
        if ($this->isShowButtons) {
            echo Html::tag('div', '', ['class' => 'form-group markdown-body editor-preview js-editor-preview']);
        }
    }
}