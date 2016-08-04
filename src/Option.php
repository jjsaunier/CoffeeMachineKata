<?php

namespace CoffeeMachine;


interface Option
{
    public static function getName() : string;

    public function getIdentifier() : string;
}
