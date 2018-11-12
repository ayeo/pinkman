<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class NestedAsArrayItem
{
    private $array = [];

    public function __construct()
    {
        $this->array[] = new Child();
        $this->array[] = new Child();
    }
}
