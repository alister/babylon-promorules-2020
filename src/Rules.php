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
        $countOfLHs = 0;
        $costOfLH = Money::GBP(0);  // not sure we have any yet
        foreach ($cart as $item) {
            if ($item->id = '001') {
                $countOfLHs ++;
                $costOfLH = $item->cost;
            }
        }
        if ($countOfLHs >= 2) {
            $costOfLH = Money::GBP(850);    // buy 2+, pay £8.50 each
            // this only covers buying one at a time. We'll be back for the others
        }
        return $totalCost->add($costOfLH);
    }

    public function CartValueGt60($cart, Money $totalCost)
    {
        return $totalCost;
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
            $totalCost = $this->{$ruleFunction}($cart, $totalCost);
        }
        return $totalCost;
    }
}
