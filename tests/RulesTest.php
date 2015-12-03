<?php
namespace Alister\Test\Babylon\Cart;

use Alister\Babylon\Cart\Rules;
use Alister\Babylon\Cart\Item;
use Money\Money;

/**
 * RulesTest
 *
 * @group group
 */
class RulesTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->rules = new Rules();
    }

    /**
     * When buying 2 'Lavender heart's, you pay less for them.
     *
     * @return [type] [description]
     */
    public function testTwoReducedItems()
    {
        $item = new Item('001', 'Lavender heart', Money::GBP(925));
        $cart[] = $item;
        $cart[] = $item;  // 2nd item

        $cost = $this->rules->lavenderHeartReduced($cart, Money::GBP(0));
        $costReducedLavHeart = Money::GBP(850);

        $this->assertEquals($cost, $costReducedLavHeart);
    }
}
