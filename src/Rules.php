<?php
namespace Alister\Babylon\Cart;

use Money\Money;

/**
*
*/
class Rules
{
    /**
     * Rules that examine the cart, and may elect to return a price for the 
     * current item.
     *
     * If it returns NULL, it will try the next item in the list
     *
     * @param Item $item [description]
     *
     * @return [type] [description]
     */
    public function getRules()
    {
        return array(
            [$this, 'lavenderHeartReduced'],
            [$this, 'defaultPrice'],    
            // must always have the default in last place
        );
    }

    public function getRulesFinal()
    {
        return array(
            'over60' => [$this, 'CartValueGt60'],
        );
    }

    public function defaultPrice(Item $item, $cart, Money $totalCost)
    {
        return $item->cost;
    }

    public function lavenderHeartReduced(Item $item, array $cart, Money $totalCost)
    {
        if (! $item->equals('001')) {
            // does not not deal with a Lavender Heart
            return null;
        }

        $countOfLHs = 0;
        $costOfLH = Money::GBP(0);  // not sure we have any yet
        foreach ($cart as $cartHasItem) {
            if ($cartHasItem->equals('001')) {
                $countOfLHs ++;
                $costOfLH = $cartHasItem->cost;
            }
        }

        if ($countOfLHs >= 2) {
            $costOfLH = Money::GBP(850);    // buy 2+, pay £8.50 each
            // this only covers buying one at a time. We'll be back for the others
        }

        return $costOfLH;
    }

    public function CartValueGt60(array $cart, Money $totalCost)
    {
        $discount10Pc = Money::GBP(6000);
        if ($totalCost->greaterThan($discount10Pc)) {
            return $totalCost->multiply(0.9); // 10% off, paying only 90%
        }

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

        $loopingCart = array_keys($cart);
        $loop = 0;
        foreach ($loopingCart as $k) {
            foreach($this->getRules() as $ruleFunction) {
                $t = $ruleFunction($cart[$k], $cart, $totalCost);
                if ($t) {
                    $totalCost = $totalCost->add($t);
                    break;
                }
            }
        }

        foreach ($this->getRulesFinal() as $id=>$ruleFunction) {
            $totalCost = $ruleFunction($cart, $totalCost);
        }
        return $totalCost;
    }
}
