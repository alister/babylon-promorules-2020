<?php
namespace Alister\Babylon\Cart;

/**
* 
*/
class Checkout implements Checkoutable
{
    /**
     * @var Item[]
     */
    private $cart;

    private $rules;

    function __construct(Rules $promoRules)
    {
        $this->rules = $promoRules;
    }

    public function scan(Item $item) 
    {
        $this->cart[] = $item;
    }

    public function total()
    {
        
    }
}
