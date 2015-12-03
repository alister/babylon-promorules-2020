<?php
namespace Alister\Test\Babylon\Cart;

use Alister\Babylon\Cart\Checkout;
use Alister\Babylon\Cart\Rules;
use Alister\Babylon\Cart\Item;
use Money\Money;

/**
 * CheckoutTest
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
        $this->assertCount(1, $this->c->cartItems());
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

    public function testTwoItemSimple()
    {
        $item003 = new Item('003', 'Kids T-shirt', Money::GBP(1995));
        $this->c->scan($item003);
        $this->c->scan($item003);

        $this->assertCount(2, $this->c->cartItems());

        $this->assertEquals(
            $this->c->total(),
            Money::GBP(1995*2)
        );
    }

    /**
     * When buying more than £60, deduct 10% (BUT first has item discount)
     *
     * Check as we go as well.
     * 
     * @return [type] [description]
     */
    public function testSpecialPriceWithItemDiscounts()
    {
        $item001 = new Item('001', 'Lavender heart', Money::GBP(925));
        $item002 = new Item('002', 'Personalised cufflinks', Money::GBP(4500));
        $item003 = new Item('003', 'Kids T-shirt', Money::GBP(1995));
        $this->c->scan($item001);
        $this->assertCount(1, $this->c->cartItems());
        #$this->assertEquals(Money::GBP(925), $this->c->total());

        $this->c->scan($item002);
        $this->assertCount(2, $this->c->cartItems());
        $this->assertContains($item002, $this->c->cartItems());
        $this->assertContains($item001, $this->c->cartItems());
        $tot = $this->c->total();
        $this->assertInstanceOf('\Money\Money', $tot);
        $this->assertEquals(Money::GBP(925+4500), $tot);

        $this->c->scan($item003);
        $this->assertCount(3, $this->c->cartItems());
        $this->assertEquals(Money::GBP(6678), $this->c->total()); // (925+4500+1995) -10%

        $this->c->scan($item001); // 2nd Lavender Heart, so they both cost £8.50
        $this->assertCount(4, $this->c->cartItems());

        $cost = $this->c->total();
        $nominalTotal = Money::GBP(925+925+4500+1995); // = 8345 (if just adding them all up)
        $this->assertNotEquals($cost, $nominalTotal, 'rule did not apply 10% discount');

        $expectedAfterDiscounts = Money::GBP(7376); // (850+850+4500+1995) - 10%
        $this->assertEquals($cost, $expectedAfterDiscounts);
        // @todo prefer to round down pennies
    }
}
