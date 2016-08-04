<?php

namespace CoffeeMachine;

class CoffeeMachineRepository
{
    /**
     * @var Drink[]
     */
    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function save(Drink $drink)
    {
        $this->data[] = $drink;
    }

    /**
     * @return Drink[]
     */
    public function getAll() : array
    {
        return $this->data;
    }
}
