<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests\Sample;

class Container
{
    private $item;

    public function __construct()
    {
        $this->item = new NestedObject();
    }
}