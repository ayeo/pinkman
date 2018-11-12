<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class ObjectWithArray
{
    private $items = [];

    public function add($item): void
    {
        $this->items[] = $item;
    }
}
