<?php
namespace Alister\Babylon\Cart;

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

    public function run(Checkout $cart)
    {
        foreach ($this->getRules() as $id=>$ruleFunction) {
            return $this->{$ruleFunction}($cart);
        }
    }
}
