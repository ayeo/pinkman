<?php

declare(strict_types=1);

namespace Ayeo\Pinkman\Tests\Sample;

class UnaryVO
{
    /**
     * @var string
     */
    private $value;

    private $irrelevantData = [
        '12' => 3453,
        'test' => 'wat?'
    ];

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
