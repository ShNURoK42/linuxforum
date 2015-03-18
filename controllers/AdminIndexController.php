<?php

namespace app\controllers;

/**
 * Class AdminIndexController
 */
class AdminIndexController extends \app\components\BaseAdminController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}