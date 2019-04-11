<?php

namespace Ayeo\Pinkman\Tests\Sample;

class ObjectWithOptionalObject
{

    /**
     * @var NestedAsArrayItem|null
     */
    private $nestedAsArrayItem;

    public function __construct(?NestedAsArrayItem $nestedAsArrayItem)
    {
        $this->nestedAsArrayItem = $nestedAsArrayItem;
    }
}
