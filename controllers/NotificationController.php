<?php

namespace app\controllers;

/**
 * Class NotificationController
 */
class NotificationController extends \app\components\BaseController
{
    public function actionView()
    {
        return $this->render('view');
    }
}
