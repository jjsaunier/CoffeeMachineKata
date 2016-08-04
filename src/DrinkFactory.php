<?php

namespace CoffeeMachine;


use CoffeeMachine\Drinks\Chocolate;
use CoffeeMachine\Drinks\Coffee;
use CoffeeMachine\Drinks\OrangeJuice;
use CoffeeMachine\Drinks\Tea;

class DrinkFactory
{
    private $drinks;

    public function __construct()
    {
        $this->drinks = [
            Chocolate::getName() => Chocolate::class,
            Tea::getName() => Tea::class,
            Coffee::getName() => Coffee::class,
            OrangeJuice::getName() => OrangeJuice::class
        ];
    }

    /**
     * @param string     $drinkName
     * @param array $options
     *
     * @return Drink
     */
    public function createNamed(string $drinkName, array $options = [])
    {
        return new $this->drinks[$drinkName]($options);
    }
}
