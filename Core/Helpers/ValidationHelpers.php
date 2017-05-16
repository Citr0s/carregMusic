<?php

namespace CarregMusic\Helpers;

class ValidationHelpers
{
    public static function sanitise($value) {
        return htmlentities($value);
    }
}