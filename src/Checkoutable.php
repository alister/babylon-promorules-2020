<?php
namespace Alister\Babylon\Cart;

use Money\Money;

interface Checkoutable
{
    public function scan(Item $item);
    public function total(): Money;
}
