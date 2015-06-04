<?php

namespace tag\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use tag\models\Tag;

class AjaxController extends \yii\web\Controller
{
    /**
     * @return string
     */
    public function actionTag()
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $query = Yii::$app->getRequest()->get('query');

            if ($query != null) {
                $rows = Tag::find()
                    ->where(['like', 'name', $query])
                    //->orderBy(['created_at' => SORT_DESC])
                    ->limit(5)
                    ->asArray()
                    ->all();

                $tags = array_unique(ArrayHelper::getColumn($rows, 'name'));
                $tags = array_values($tags);

                return $tags;
            }
        }

        throw new NotFoundHttpException();
    }
}
