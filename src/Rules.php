<?php
namespace Alister\Babylon\Cart;

use Money\Money;

/**
*
*/
class Rules
{
    public function getRules()
    {
        // name => [ 'updateCheckout function($cart)'  ]
        return array(
            'hasLavenderHeart' => 'lavenderHeartReduced',
            'over60'           => 'CartValueGt60',
        );
    }

    public function lavenderHeartReduced($cart, Money $totalCost)
    {
        return Money::GBP(925);
    }

    public function CartValueGt60($cart, Money $totalCost)
    {
        return Money::GBP(0);
    }

    /**
     * [runForPrice description]
     *
     * @param Items[] $cart
     *
     * @return Money total price of cart
     */
    public function runForPrice(array $cart)
    {
        $totalCost = Money::GBP(0);
        foreach ($this->getRules() as $id=>$ruleFunction) {
            $totalCost = $totalCost->add(
                $this->{$ruleFunction}($cart, $totalCost)
            );
        }
        return $totalCost;
    }
}
