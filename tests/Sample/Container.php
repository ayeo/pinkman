<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class Container
{
    private $item;

    public function __construct()
    {
        $this->item = new NestedObject();
    }
}