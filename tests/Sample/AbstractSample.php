<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests\Sample;

abstract class AbstractSample
{
    private $property1;

    public function __construct($property1 = 'property1')
    {
        $this->property1 = $property1;
    }

    public function getProperty1(): string
    {
        return $this->property1;
    }

}