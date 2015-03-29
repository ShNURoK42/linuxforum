<?php
namespace app\widgets;

use Yii;
use yii\base\Model;

class PostFormbox extends \yii\base\Widget
{
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
     * @var boolean
     */
    public $enablePreview = true;


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

        $this->getView()->registerJs("jQuery('.post-formbox').postPreview();");

        echo $this->render('postFormbox', [
            'user' => $user,
            'model' => $this->model,
            'messageAttribute' => $this->messageAttribute,
            'titleAttribute' => $this->titleAttribute,
            'activeFormOptions' => $activeFormOptions,
        ]);
    }
}