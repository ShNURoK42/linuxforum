<?php

namespace common\components;

use Yii;
use yii\base\InvalidParamException;
use NumberFormatter;

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

    /**
     * Shorten large numbers into abbreviations (i.e. 1450 = 1k)
     *
     * @param integer $value value to be formatted.
     * @param array $options optional configuration for the number formatter. This parameter will be merged with [[numberFormatterOptions]].
     * @param array $textOptions optional configuration for the number formatter. This parameter will be merged with [[numberFormatterTextOptions]].
     * @return string a number with a symbol
     */
    function asNumberAbbreviation($value, $options = [], $textOptions = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        if (is_string($value) && is_numeric($value)) {
            $value = (int)$value;
        }
        if (!is_numeric($value)) {
            throw new InvalidParamException("'$value' is not a numeric value.");
        }

        $position = 0;
        while ($position < 5) {
            if (abs($value) < 1000) {
                break;
            }
            $value = intval(round($value / 1000));
            $position++;
        };

        $options[NumberFormatter::GROUPING_USED] = false;

        $result = $this->asDecimal($value, null, $options, $textOptions);
        switch ($position) {
            case 1:  return $result . 'k';
            case 2:  return $result . 'm';
            case 3:  return $result . 'b';
            case 4:  return $result . 't';
            default: return $result;
        }
    }
}