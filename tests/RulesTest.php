<?php
namespace Alister\Test;

use Alister\Babylon\Cart\Rules;
use Alister\Babylon\Cart\Item;
use Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * RulesTest
 */
class RulesTest extends TestCase
{
    /** @var \Alister\Babylon\Cart\Rules */
    private $rules;

    public function setUp(): void
    {
        $this->rules = new Rules();
    }

    /**
     * When buying 2 'Lavender heart's, you pay less for them.
     */
    public function testTwoReducedItems(): void
    {
        $item = new Item('001', 'Lavender heart', Money::GBP(925));
        $cart[] = $item;
        $cart[] = $item;  // 2nd item

        $cost = $this->rules->lavenderHeartReduced($item, $cart, Money::GBP(0));
        $costReducedLavHeart = Money::GBP(850);

        $this->assertEquals($cost, $costReducedLavHeart);
    }

    /**
     * When buying more than £60, deduct 10%
     */
    public function testMoreThanTotal60(): void
    {
        $item001 = new Item('001', 'Lavender heart', Money::GBP(925));
        $item002 = new Item('002', 'Personalised cufflinks', Money::GBP(4500));
        $item003 = new Item('003', 'Kids T-shirt', Money::GBP(1995));
        $cart[] = $item001;
        $cart[] = $item002;
        $cart[] = $item003;

        $nominalTotal = Money::GBP(925+4500+1995); // = 7420
        $cost = $this->rules->CartValueGt60($cart, $nominalTotal);

        $this->assertNotEquals($cost, $nominalTotal, 'rule did not apply 10% discount');
        $expectedAfterDiscount = Money::GBP(6678); // 7420 - 10%
        $this->assertEquals($cost, $expectedAfterDiscount);
    }
}
