<?php
namespace Alister\Test;

use \Money\Money;

/**
 * MoneyTest
 *
 * @group done
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    public function testMoney()
    {
        $cartTotal = Money::GBP(2500);
        $coupon = Money::GBP(100);
        $cartTotal = $cartTotal->subtract($coupon);
        
        $this->assertTrue(
            $cartTotal->equals(Money::GBP(2400)),
            "cart <> £24.00 !"
        );
        $this->assertEquals($cartTotal->getUnits(), 2400);
    }
}
