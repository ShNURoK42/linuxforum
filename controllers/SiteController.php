<?php

namespace app\controllers;

use app\models\Post;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use app\models\Category;
use app\models\ForumPermission;

/**
 * Class SiteController
 */
class SiteController extends \app\components\BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $permissionRows = ForumPermission::find()
            ->select('forum_id')
            ->where([
                'group_id' => Yii::$app->getUser()->getGroupID(),
                'read_forum' => 0
            ])
            ->all();

        $listIDs = ArrayHelper::getColumn($permissionRows, 'forum_id');

        $params = function ($query) use ($listIDs) {
            /** @var \yii\db\Query $query */
            $query->andWhere(['NOT IN', 'forums.id', $listIDs])
                ->orderBy(['disp_position' => SORT_ASC]);
        };

        $categories = Category::find()
            ->joinWith(['forums' => $params])
            ->all();

        return $this->render('index', ['categories' => $categories]);
    }

    /**
     * This action render the rule page.
     * @return string
     */
    public function actionTerms()
    {
        return $this->render('terms');
    }

    /**
     * This action render the search page.
     * @return string
     */
    public function actionSearch()
    {
        return $this->render('search');
    }

    /**
     * This action render the markdown helper page.
     * @return string
     */
    public function actionMarkdown()
    {
        $post = Post::findOne(['id' => 450994]);

        return $this->render('markdown', ['post' => $post]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }

        $name = 'Ошибка';
        if ($code == 404) {
            $message = 'Страницы с таким адресом не существует.';
        } else {
            $message = 'Неверный запрос. Ссылка ошибочная или устарела.';
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('info', ['params' => [
                'name' => $name,
                'message' => $message,
            ]]);
        }
    }
}
