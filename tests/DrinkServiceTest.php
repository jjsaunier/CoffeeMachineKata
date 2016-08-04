<?php

namespace Tests\CoffeeMachine;

use CoffeeMachine\CoffeeMachineRepository;
use CoffeeMachine\DrinkFactory;
use CoffeeMachine\DrinkMaker;
use CoffeeMachine\DrinkService;

class DrinkServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var DrinkService */
    private $sut;

    public function setUp()
    {
        $this->sut = new DrinkService(new DrinkFactory(), new CoffeeMachineRepository());
    }

    /**
     * @test
     */
    public function it_should_give_me_tea_with_sugar_and_stick()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('T:1:0')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'tea', 'sugar' => 1, 'money' => 0.4], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_a_chocolate()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('H::')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'chocolate', 'money' => 0.5], $drinkMaker->reveal());
    }


    /**
     * @test
     */
    public function is_should_prepare_coffee_with_overpaid()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('C::')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'coffee', 'money' => 10], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_coffee_two_sugar_with_stick()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('C:2:0')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'coffee', 'sugar' => 2, 'money' => 0.6], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_not_prepare_coffee()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('M:Not enough money - 0.5 is missing')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'coffee', 'money' => 0.1], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_orange_juice()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('O::')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'orange_juice', 'money' => 0.6], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_extra_hot_coffee()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('Ch::')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'coffee', 'money' => 0.6, 'options' => ['extra_hot']], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_extra_hot_chocolate_with_sugar_and_stick()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('Hh:1:0')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'chocolate', 'sugar' => 1, 'money' => 0.5, 'options' => ['extra_hot']], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_prepare_extra_hot_tea_with_two_sugar_and_stick()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $drinkMaker->handle('Th:2:0')->shouldBeCalled();
        $this->sut->sendOrder(['drink' => 'tea', 'sugar' => 2, 'money' => 0.4, 'options' => ['extra_hot']], $drinkMaker->reveal());
    }

    /**
     * @test
     */
    public function it_should_generate_me_a_report()
    {
        $drinkMaker = $this->prophesize(DrinkMaker::class);
        $this->sut->sendOrder(['drink' => 'tea', 'sugar' => 2, 'money' => 0.4, 'options' => ['extra_hot']], $drinkMaker->reveal());
        $this->sut->sendOrder(['drink' => 'chocolate', 'sugar' => 1, 'money' => 0.5,], $drinkMaker->reveal());
        $this->sut->sendOrder(['drink' => 'chocolate', 'sugar' => 1, 'money' => 0.5, 'options' => ['extra_hot']], $drinkMaker->reveal());
        $this->sut->sendOrder(['drink' => 'tea', 'sugar' => 2, 'money' => 0.4, 'options' => ['extra_hot']], $drinkMaker->reveal());
        $this->sut->sendOrder(['drink' => 'orange_juice', 'money' => 0.6], $drinkMaker->reveal());

        $result = $this->sut->getReport()->getResult();

        $expectedReportResult = [
            'drinks' => [
                'tea' => 2,
                'chocolate' => 2,
                'orange_juice' => 1
            ],
            'total_amount' => 2.4
        ];

        $this->assertEquals($expectedReportResult, $result);
    }
}
