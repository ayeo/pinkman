<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class NestedAsProperty
{
    private $nested;

    public function __construct()
    {
        $this->nested = new Child();
    }
}
