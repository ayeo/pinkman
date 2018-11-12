<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests;

use Ayeo\Pinkman\Hydrator;
use Ayeo\Pinkman\Tests\Sample\ExtendedObjectWithPrivate;
use Ayeo\Pinkman\Tests\Sample\Recursive;
use PHPUnit\Framework\TestCase;

class HydratorTest extends TestCase
{
    /**
     * Proves private property in nested class works fine
     * When deserialize ExtendedObjectWithPrivate then private goes to parent
     *
     * @throws \Exception
     */
    public function testNestedPrivateProperty()
    {
        $data = [
            'property1' => 'property1',
            'property2' => 'property2'
        ];
        $config = [
            'class' => ExtendedObjectWithPrivate::class
        ];
        $object = $this->getHydrator()->process($data, $config);
        $expected = new ExtendedObjectWithPrivate('property1', 'property2');
        $this->assertEquals($expected, $object);
    }

    /**
     * @throws \Exception
     */
    public function testNestedArray(): void
    {
        $data = [
            2 => [
                4 => [
                    'name' => 'Awesome',
                    'count' => [
                        'list' => 5
                    ]
                ]
            ]
        ];

        $config = [
            'content' => [
                'content' => [
                    'class' => \stdClass::class,
                    'content' => [
                        'count' => [
                            'class' => \stdClass::class
                        ]
                    ]
                ]
            ]
        ];

        $z = new \stdClass();
        $z->name = 'Awesome';
        $z->count = new \stdClass();
        $z->count->list = 5;
        $expected[2][4] = $z;

        $this->assertEquals($expected, $this->getHydrator()->process($data, $config));
    }

    /**
     * @throws \Exception
     */
    public function testRecursive(): void
    {
        $data = [
            'name' => 'test1',
            'values' => [
                [
                    'name' => 'test2',
                    'values' => [
                        [
                            'name' => 'test3',
                            'values' => [
                                [
                                    'name' => 'test4',
                                    'values' => [
                                        [
                                            'name' => 'test5',
                                            'values' => []
                                        ]

                                    ]
                                ]

                            ]
                        ]
                    ]
                ]
            ],
        ];

        $recursive0 = new Recursive('test1');
        $recursive1 = new Recursive('test2');
        $recursive2 = new Recursive('test3');
        $recursive3 = new Recursive('test4');
        $recursive4 = new Recursive('test5');
        $recursive3->setItem($recursive4);
        $recursive2->setItem($recursive3);
        $recursive1->setItem($recursive2);
        $recursive0->setItem($recursive1);

        $config = $this->getConfig()['content'];
        $this->assertEquals($recursive0, $this->getHydrator()->process($data, $config));
    }

    private function getConfig(): array
    {
        $self = $this;
        return [
            'content' => [
                'class' => Recursive::class,
                'content' => [
                    'values' => function () use ($self) {
                        return $self->getConfig();
                    }
                ]
            ]
        ];
    }

    private function getHydrator(): Hydrator
    {
        return new Hydrator();
    }
}