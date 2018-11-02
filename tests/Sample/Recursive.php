<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests\Sample;

class Recursive
{
    private $name = 'test';

    /** @var Recursive[] */
    private $values = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setItem(Recursive $recursive)
    {
        $this->values[] = $recursive;
    }
}