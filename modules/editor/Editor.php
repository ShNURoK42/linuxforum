<?php
namespace editor;

use Yii;
use yii\base\Model;

class Editor extends \yii\base\Widget
{
    /**
     * @var string
     */
    public $type = 'default';
    /**
     * @var Model the data model that this field is associated with
     */
    public $model;
    /**
     * @var string the model attribute that this field is associated with
     */
    public $messageAttribute;
    /**
     * @var string
     */
    public $titleAttribute;
    /**
     * @var array
     */
    public $activeFormOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $user = Yii::$app->getUser()->getIdentity();

        $activeFormOptions['options'] = [
            'id' => 'postform',
            'class' => 'postform-create',
        ];

        $activeFormOptions = array_merge($this->activeFormOptions, $activeFormOptions);

        echo $this->render('editor', [
            'user' => $user,
            'model' => $this->model,
            'messageAttribute' => $this->messageAttribute,
            'titleAttribute' => $this->titleAttribute,
            'activeFormOptions' => $activeFormOptions,
        ]);
    }

    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        EditorAsset::register($view);
        $view->registerJs("jQuery('.post-formbox').editor();");
    }
}