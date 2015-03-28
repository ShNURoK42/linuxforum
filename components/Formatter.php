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
        $this->timeZone = 'Europe/Moscow';
    }

    public function asTimeAgo($time)
    {
        if ($time === null) {
            return $this->nullDisplay;
        }

        $diff = time() - $time;
        if ($diff < 10) {
            return 'только что';
        }
        if ($diff < 60) {
            $sec = $diff;
            return $this->numberEnding($sec, ['секунду','секунды','секунд']) . ' назад';
        }
        if ($diff < 120) {
            return 'минуту назад';
        }
        if ($diff < 3600) {
            $min = floor($diff / 60);
            return $this->numberEnding($min, ['минуту','минуты','минут']) . ' назад';
        }
        if ($diff < 7200) {
            return 'час назад';
        }
        if ($diff < 86400) {
            $hour = floor($diff / 3600);
            if (date('j') == intval(date('j', $time))) {
                return $this->numberEnding($hour, ['час', 'часа', 'часов']) . ' назад';
            }
        }
        if ($diff < 172800 && date('j', strtotime('-1 day')) == date('j', $time)) {
            return 'вчера';
        }
        if ($diff < 259200 && date('j', strtotime('-2 day')) == date('j', $time)) {
            return 'позавчера';
        }
        $formatter = Yii::$app->formatter;
        if (date('Y') == date('Y', $time)) {
            return $formatter->asDate($time, 'd MMMM');
        }

        return $formatter->asDate($time, 'd MMM y');
    }

    protected function numberEnding($number, $titles = [])
    {
        $cases = array (2, 0, 1, 1, 1, 2);
        return $number . " " . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}