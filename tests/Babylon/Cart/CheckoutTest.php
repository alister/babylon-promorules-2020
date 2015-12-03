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
        $this->rules = new Rules();
        $this->c = new Checkout($this->rules);
    }

    public function testCanCreate()
    {
        $this->assertInstanceOf('Alister\Babylon\Cart\Checkout', $this->c);
        $this->assertEmpty($this->c->cartItems());
    }

    public function testScanItem()
    {
        $costLavHeart = Money::GBP(925);
        $item = new Item('001', 'Lavender heart', $costLavHeart);
        $this->c->scan($item);
    }

    public function testSimpleTotalCost()
    {
        $costLavHeart = Money::GBP(925);
        $item = new Item('001', 'Lavender heart', $costLavHeart);
        $this->c->scan($item);

        $this->assertCount(1, $this->c->cartItems());

        $this->assertEquals(
            $this->c->total(),
            $costLavHeart
        );
    }
}
