<?php

namespace captcha\controllers;

use Yii;

/**
 * Class DefaultController
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\captcha\CaptchaAction',
                'testLimit' => 1,
                'offset' => -2,
                'padding' => 0,
                'width' => 200,
                'height' => 50,
                'minLength' => 4,
                'maxLength' => 7,
                'transparent' => true,
                'foreColor' => 0x2A6496,
                //'fixedVerifyCode' => 'test',
            ],
        ];
    }
}
