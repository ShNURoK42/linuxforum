<?php

namespace app\components;

use Yii;
use yii\web\NotFoundHttpException;
use app\helpers\AccessHelper;

/**
 * Class BaseAdminController
 */
class BaseAdminController extends \yii\web\Controller
{
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!AccessHelper::isAdmMod()) {
                throw new NotFoundHttpException();
            }

            return true;
        } else {
            return false;
        }
    }
}