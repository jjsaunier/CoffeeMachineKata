<?php

declare(strict_types=1);

namespace CoffeeMachine;

interface DrinkMaker
{
    public function handle(string $order);
}
