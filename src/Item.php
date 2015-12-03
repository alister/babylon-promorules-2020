<?php
namespace Alister\Babylon\Cart;

use Money\Money;

/**
*
*/
class Item
{
    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var Money */
    public $cost;

    public function __construct($id, $name, Money $cost)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cost = $cost;
    }
}
