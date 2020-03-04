<?php
namespace Alister\Babylon\Cart;

use Money\Money;

class Checkout implements Checkoutable
{
    /** @var Item[] */
    private $cart;
    /** @var Rules */
    private $rules;

    public function __construct(Rules $promoRules)
    {
        $this->rules = $promoRules;
    }

    /**
     * @return \Alister\Babylon\Cart\Item[]|array
     */
    public function cartItems(): ?array
    {
        return $this->cart;
    }

    /**
     * accumulate items in the cart
     */
    public function scan(Item $item): self
    {
        $this->cart[] = $item;
        return $this;
    }

    public function total(): Money
    {
        return $this->rules->runForPrice($this->cart);
    }
}
