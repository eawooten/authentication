<?php

namespace Violin\Rules;

use Violin\Contracts\RuleContract;

class BetweenRule implements RuleContract
{
    public function run($value, $input, $args)
    {
        return ($value >= $args[0] && $value <= $args[1]) ? true : false;
    }

    public function error()
    {
        return '{field} must be between {arg} and {arg:1}.';
    }
}
