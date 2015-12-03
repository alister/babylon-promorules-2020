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
    private $rulesHaveRun = false;

    function __construct(Rules $promoRules)
    {
        $this->rules = $promoRules;
    }

    /**
     * accumulate items in the cart
     *
     * @param Item $item [description]
     *
     * @return self
     */
    public function scan(Item $item) 
    {
        $this->cart[] = $item;
        return $this;
    }

    public function total()
    {
        return $this->rules->runForPrice($this->cart);
    }
}
