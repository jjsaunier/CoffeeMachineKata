<?php

namespace CoffeeMachine\Options;

use CoffeeMachine\Option;

class ExtraHotOption implements Option
{
    public static function getName() : string
    {
        return 'extra_hot';
    }

    public function getIdentifier() : string
    {
        return 'h';
    }
}
