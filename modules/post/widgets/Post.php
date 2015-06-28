<?php
namespace post\widgets;

use Yii;
use yii\base\InvalidConfigException;
use post\models\Post as PostModel;
use post\models\UpdateForm;
use post\PostAsset;

class Post extends \yii\base\Widget
{
    /**
     * @var PostModel
     */
    public $post;
    /**
     * @var integer
     */
    public $count;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->post instanceof PostModel) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
        if (!isset($this->count)) {
            $this->count = 1;
        }
        $this->registerClientScript();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new UpdateForm();
        $model->message = $this->post->message;

        echo $this->render('post', [
            'post' => $this->post,
            'count' => $this->count,
            'model' => $model,
        ]);
    }

    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        PostAsset::register($view);
    }
}