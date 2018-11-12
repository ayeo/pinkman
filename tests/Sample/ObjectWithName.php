<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class ObjectWithName
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
