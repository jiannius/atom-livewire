<?php

namespace Jiannius\Atom\Services;

use Illuminate\Support\Number;

class Util
{
    public static function currency(
        $value,
        $symbol = null,
        $rounding = false,
        $bracket = false,
        $short = false,
    ) : string
    {
        if (!is_numeric($value)) return $value;

        $value = (float) $value;

        if ($short) {
            $amount = static::short($value);
            $currency = $symbol ? "$symbol $amount" : $amount;
        }
        else {
            $amount = $rounding ? (round((float) $value * 2, 1)/2) : $value;
            $currency = $symbol ? ($symbol.' '.Number::format($amount, 2)) : Number::format($amount, 2);
        }

        return ($bracket && $value < 0) ? '('.str($currency)->replaceFirst('-', '').')' : $currency;
    }

    public static function uncurrency($value) : float
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $value);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $value);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
    }

    public static function short($value, $locale = null) : string
    {
        if (!is_numeric($value)) return $value;

        $value = (float) $value;

        if ($value > 999999999) return round(($value/1000000000), 2).'B';
        if ($value > 999999) return round(($value/1000000), 2).'M';
        if ($value > 999) return round(($value/1000), 2).'K';
    
        return $value;
    }
}