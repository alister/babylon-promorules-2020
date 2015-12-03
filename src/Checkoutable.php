<?php
namespace Alister\Babylon\Cart;

/**
*
*/
interface Checkoutable
{
    public function scan(Item $item);
    public function total();
}
