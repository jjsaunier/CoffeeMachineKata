<?php

namespace CoffeeMachine;

interface Drink
{
    public static function getName() : string;

    public function getIdentifier() : string;

    public function getPrice() : float;

    public function haveExtraHotOption() : bool;
}
