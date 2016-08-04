<?php

namespace CoffeeMachine;

use CoffeeMachine\Options\ExtraHotOption;

class DrinkService
{
    private $drinkFactory;

    private $coffeeMachineRepository;

    public function __construct(DrinkFactory $drinkFactory, CoffeeMachineRepository $coffeeMachineRepository)
    {
        $this->drinkFactory = $drinkFactory;
        $this->coffeeMachineRepository = $coffeeMachineRepository;
    }

    private function prepare(array $order)
    {
        $extraHotOption = new ExtraHotOption();

        $options = [
            $extraHotOption->getName() => $extraHotOption
        ];

        $requestedOptions = [];

        if(isset($order['options'])){
            foreach($order['options'] as $requestedOption){
                $requestedOptions[$requestedOption] = $options[$requestedOption];
            }
        }

        $requestedDrink = $this->drinkFactory->createNamed($order['drink'], $requestedOptions);

        $payload = [];

        if($order['money'] < $requestedDrink->getPrice()){
            return 'M:Not enough money - ' . round($requestedDrink->getPrice() - $order['money'], 2). ' is missing';
        }

        $this->coffeeMachineRepository->save($requestedDrink);

        $payload[] = $requestedDrink->getIdentifier();
        $payload[] = isset($order['sugar']) ? $order['sugar'] : '';
        $payload[] = isset($order['sugar']) ? 0 : '';

        return implode(':', $payload);
    }

    public function getReport() : CoffeeMachineReport
    {
        return new CoffeeMachineReport($this->coffeeMachineRepository->getAll());
    }

    public function sendOrder(array $order, DrinkMaker $drinkMaker)
    {
        $drinkMaker->handle($this->prepare($order));
    }
}
