<?php

namespace common\components;

use DateInterval;
use DateTime;
use Yii;

class DateTimeAgo
{
    /**
     * @var string $format
     */
    protected $format = 'Y-m-d';

    /**
     * Get string representation of the date with given translator
     * @param integer $timestamp
     * @param DateTime|null $currentDate
     * @return string
     */
    public function get($timestamp, $currentDate = null)
    {
        if (is_null($currentDate)) {
            $currentDate = new DateTime();
        }

        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp);

        $diff = $currentDate->diff($dateTime);
        return $this->getText($diff, $dateTime);
    }

    /**
     * Get string related to DateInterval object
     * @param DateInterval $diff
     * @param DateTime $date
     * @return string
     */
    protected function getText($diff, $date)
    {
        if ($this->now($diff)) {
            return 'только что';
        }
        if ($min = $this->minutes($diff)) {
            return $min . ' ' . Yii::$app->formatter->numberEnding($min, ['минуту', 'минуты', 'минут']) . ' назад';
        }
        if ($h = $this->hours($diff)) {
            return $h . ' ' . Yii::$app->formatter->numberEnding($h, ['час', 'часа', 'часов']) . ' назад';
        }
        if ($d = $this->days($diff)) {
            return $d . ' ' . Yii::$app->formatter->numberEnding($d, ['день', 'дня', 'дней']) . ' назад';
        }
        if ($m = $this->months($diff)) {
            return $m . ' ' . Yii::$app->formatter->numberEnding($m, ['месяц', 'месяца', 'месяцев']) . ' назад';
        }
        if ($y = $this->years($diff)) {
            return $y . ' ' . Yii::$app->formatter->numberEnding($y, ['год', 'года', 'лет']) . ' назад';
        }

        return $date->format($this->format);
    }

    /**
     * Is date limit by day
     * @param DateInterval $diff
     * @return bool
     */
    protected function daily($diff)
    {
        if (($diff->y == 0) && ($diff->m == 0) && (($diff->d == 0) || (($diff->d == 1) && ($diff->h == 0) && ($diff->i == 0)))) {
            return true;
        }
        return false;
    }

    /**
     * Is date limit by hour
     * @param DateInterval $diff
     * @return bool
     */
    protected function hourly($diff)
    {
        if ($this->daily($diff) && ($diff->d == 0) && (($diff->h == 0) || (($diff->h == 1) && ($diff->i == 0)))) {
            return true;
        }
        return false;
    }

    /**
     * @param DateInterval $diff
     * @return bool
     */
    protected function now($diff)
    {
        if ($this->hourly($diff) && ($diff->h == 0) && ($diff->i == 0) && ($diff->s <= 59)) {
            return true;
        }
        return false;
    }

    /**
     * Number of minutes related to the interval or false if more.
     * @param DateInterval $diff
     * @return integer|false
     */
    protected function minutes($diff)
    {
        if ($this->hourly($diff)) {
            return $diff->i;
        }
        return false;
    }

    /**
     * Number of hours related to the interval or false if more.
     * @param DateInterval $diff
     * @return integer|false
     */
    protected function hours($diff)
    {
        if ($this->daily($diff)) {
            return $diff->h;
        }
        return false;
    }

    /**
     * Number of days related to the interval or false if more.
     * @param DateInterval $diff
     * @return integer|false
     */
    protected function days($diff)
    {
        if ($diff->m == 0 && $diff->y == 0) {
            return $diff->d;
        }
        return false;
    }

    /**
     * Get Number of months
     * @param DateInterval $diff
     * @return integer|false
     */
    protected function months($diff)
    {
        if ($diff->y == 0) {
            return $diff->m;
        }
        return false;
    }

    /**
     * Get Number of years
     * @param DateInterval $diff
     * @return integer|false
     */
    protected function years($diff)
    {
        return $diff->y;
    }
}