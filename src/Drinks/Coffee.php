<?php

namespace CoffeeMachine\Drinks;

use CoffeeMachine\Drink;
use CoffeeMachine\Option;
use CoffeeMachine\Options\ExtraHotOption;
use Webmozart\Assert\Assert;

class Coffee implements Drink
{
    /** @var Option[]  */
    private $options;

    /**
     * Coffee constructor.
     *
     * @param Option[] $options
     */
    public function __construct($options = [])
    {
        foreach($options as $option){
            Assert::oneOf(get_class($option), [ExtraHotOption::class]);
        }

        $this->options = $options;
    }

    public static function getName() : string
    {
        return 'coffee';
    }

    public function getIdentifier() : string
    {
        if(false == $this->haveExtraHotOption()){
            return 'C';
        }

        return 'C'.$this->options[ExtraHotOption::getName()]->getIdentifier();
    }

    public function getPrice() : float
    {
        return 0.6;
    }

    public function haveExtraHotOption() : bool
    {
        foreach($this->options as $option){
            if($option instanceof ExtraHotOption){
                return true;
            }
        }
        return false;
    }
}
