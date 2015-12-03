<?php
namespace Alister\Babylon\Cart;

use Money\Money;

/**
*
*/
class Item
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var Money */
    private $cost;
    public function __construct($id, $name, Money $cost)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cost = $cost;
    }
}
