<?php

namespace app\components;

use Yii;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->datetimeFormat = 'php:' . Yii::$app->config->get('o_date_format') . ' ' . Yii::$app->config->get('o_time_format');
        $this->dateFormat = 'php:' . Yii::$app->config->get('o_date_format');
        $this->timeFormat = 'php:' . Yii::$app->config->get('o_time_format');
        $this->thousandSeparator = ' ';
    }
}