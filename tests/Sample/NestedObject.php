<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests\Sample;

class NestedObject
{
    private $name = 'Name';

    private $nested;

    public function __construct()
    {
        $this->nested = new SampleClass();
    }
}
