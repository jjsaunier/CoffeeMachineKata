<?php

namespace CoffeeMachine\Drinks;

use CoffeeMachine\Drink;

class OrangeJuice implements Drink
{
    public static function getName() : string
    {
        return 'orange_juice';
    }

    public function getIdentifier() : string
    {
        return 'O';
    }

    public function getPrice() : float
    {
        return 0.6;
    }

    public function haveExtraHotOption() : bool
    {
        return false;
    }
}
