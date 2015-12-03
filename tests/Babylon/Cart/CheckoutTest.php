<?php
namespace Alister\Test\Babylon\Cart;

use Alister\Babylon\Cart\Checkout;

/**
 * CheckoutTest
 *
 * @group group
 */
class CheckoutTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->c = new Checkout();
    }

    /**
     * @covers Alister\Test\Babylon\Cart\Checkout
     */
    public function testCanCreate()
    {
        $this->assertInstanceOf('Alister\Babylon\Cart\Checkout', $this->c);
    }
}
