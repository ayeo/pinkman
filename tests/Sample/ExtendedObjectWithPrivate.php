<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests\Sample;

class ExtendedObjectWithPrivate extends AbstractSample
{
    /** @var string */
    private $property2 = null;

    public function __construct(string $property1 = 'property1', $property2 = null)
    {
        parent::__construct($property1);
        $this->property2 = $property2;
    }

    public function getProperty2(): string
    {
        return $this->property2;
    }
}