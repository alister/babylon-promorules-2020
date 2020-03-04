<?php
namespace Alister\Test;

use \Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * MoneyTest
 *
 * @group done
 */
class MoneyTest extends TestCase
{
    public function testMoney(): void
    {
        $cartTotal = Money::GBP(2500);
        $coupon = Money::GBP(100);
        $cartTotal = $cartTotal->subtract($coupon);
        
        $this->assertTrue(
            $cartTotal->equals(Money::GBP(2400)),
            'cart <> £24.00 !'
        );
    }
}
