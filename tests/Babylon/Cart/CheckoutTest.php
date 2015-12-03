<?php
namespace Alister\Test\Babylon\Cart;

use Alister\Babylon\Cart\Checkout;
use Alister\Babylon\Cart\Rules;
use Alister\Babylon\Cart\Item;
use Money\Money;

/**
 * CheckoutTest
 *
 * @group group
 */
class CheckoutTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->c = new Checkout(new Rules());
    }

    public function testCanCreate()
    {
        $this->assertInstanceOf('Alister\Babylon\Cart\Checkout', $this->c);
    }

    public function testScanItem()
    {
        $costLavHeart = Money::GBP(925);
        $item = new Item('001', 'Lavender heart', $costLavHeart);
        $this->c->scan($item);
    }

    public function testSimpleTotalCost($value='')
    {
        $costLavHeart = Money::GBP(925);
        $item = new Item('001', 'Lavender heart', $costLavHeart);

        $this->assertEquals(
            $this->c->total(),
            $costLavHeart
        );
    }
}
