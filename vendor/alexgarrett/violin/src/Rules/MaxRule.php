<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;

class MaxRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        if (is_numeric($value)) {
            return (float) $value <= (float) $args[0];
        }

        if (is_string($value)) {
            return mb_strlen($value) <= (int) $args[0];
        }
    }

    public function error()
    {
        return '{field} must be a maximum of {arg}.';
    }
}
