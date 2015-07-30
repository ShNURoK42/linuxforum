<?php

namespace common\components;

use Yii;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->datetimeFormat = 'php:d.m.Y H:i:s';
        $this->dateFormat = 'php:d.m.Y';
        $this->timeFormat = 'php:H:i:s';
        $this->thousandSeparator = ' ';

        parent::init();
    }

    /**
     * @param $number int число чего-либо
     * @param $titles array варинаты написания для количества 1, 2 и 5
     * @return string
     */
    public function numberEnding($number, $titles = [])
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)] ];
    }
}