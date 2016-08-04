<?php

namespace CoffeeMachine;

class CoffeeMachineReport
{
    /**
     * @var Drink[]
     */
    private $drinks;

    /**
     * CoffeeMachineReport constructor.
     *
     * @param Drink[] $drinks
     */
    public function __construct($drinks = [])
    {
        $this->drinks = $drinks;
    }

    public function getResult() : array
    {
        $countOfDrink = [];
        $moneyEarn = 0;

        /** @var Drink $drink */
        foreach($this->drinks as $drink){
            if(!isset($countOfDrink[$drink->getName()])){
                $countOfDrink[$drink->getName()] = 1;
            }else{
                $countOfDrink[$drink->getName()]++;
            }

            $moneyEarn += $drink->getPrice();
        }

        return [
            'drinks' => $countOfDrink,
            'total_amount' => $moneyEarn
        ];
    }
}
