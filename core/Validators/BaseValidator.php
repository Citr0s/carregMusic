<?php

namespace CarregMusic\Validators;


class BaseValidator
{
    public static function checkStringLength($value, $min, $max) : bool
    {
        return strlen($value) >= $min && strlen($value) <= $max && !is_numeric($value);
    }

    public static function checkEmail($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function checkIntegerRange($value, $minValue, $maxValue)
    {
        $options = [
            'options' => [
                'min_range' => $minValue,
                'max_range' => $maxValue
            ]
        ];

        return filter_var($value, FILTER_VALIDATE_INT, $options);
    }
}