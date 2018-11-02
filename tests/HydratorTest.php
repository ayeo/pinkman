<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests;

//use PHPUnit\Framework\TestCase;
//use PIM\Domain\Field\Config;
//use PIM\Domain\Field\FieldFactory;
//use PIM\Domain\Field\Type\ValueType;
//use PIM\Domain\Group\Specification;
//use PIM\Domain\Field\Type\Base\EmptyConstraints;
//use PIM\Domain\Field\Type\MultilangText\Value;
//use PIM\Domain\Field\Type\Text\Field;
//use PIM\Domain\Laboratory\FlatList;
//use PIM\Domain\Laboratory\FlatListParameters;
//use PIM\Domain\Laboratory\ThingTemplate;
//use PIM\Domain\Model\FieldSymbolsCollection;
//use PIM\Domain\Model\Guid;
//use PIM\Domain\Language\LanguageCode;
//use PIM\Domain\Model\FieldSymbol;
//use PIM\Domain\Language\LanguageCodesCollection;
//use PIM\Domain\Unit\UnitRepository;
//use PIM\Domain\Utils\AntyIntruder;
//use PIM\Domain\Utils\Intruder;
//use PIM\Domain\ValuesContainer\ProductFieldsValues;
//use PIM\Domain\ValuesContainer\Values;
//use PIM\Infrastructure\EventBus;
//use PIM\Infrastructure\EventHandling\Collector;
//use PIM\Infrastructure\Persist\InMemoryDataStore;
//use PIM\Test\Domain\Utils\Sample\ExtendedObjectWithPrivate;
//use PIM\Test\Domain\Utils\Sample\Recursive;
//use PIM\Test\Utils\Group;

class AntiIntruderTest extends TestCase
{
//    public function testTest()
//    {
//        $data = [
//            'name' => 'Name',
//            'nested' => [
//                'privateProperty' => 'private value',
//                'protectedProperty' => 'protected value',
//                'publicProperty' => 'public value'
//            ]
//        ];
//
//        $unserializer = new AntyIntruder();
//        $config = [
//            'nested' => [
//                'class' => SampleA::class
//            ]
//        ];
//        $object = $unserializer->unserialize($data, NestedObject::class, $config);
//    }


//    public function testTest2()
//    {
//        $data = [
//            'item' => [
//                'name' => 'Name',
//                'nested' => [
//                    'privateProperty' => 'private value',
//                    'protectedProperty' => 'protected value',
//                    'publicProperty' => 'public value'
//                ]
//            ]
//        ];
//
//        $unserializer = new AntyIntruder();
//        $config = [
//            'item' => [
//                'class' => NestedObject::class,
//                'content' => [
//                    'nested' => [
//                        'class' => SampleA::class,
//                        'content' => []
//                    ]
//                ]
//
//            ]
//        ];
//        $object = $unserializer->unserialize($data, Container::class, $config);
//    }

    /**
     * Proves private property in nested class works fine
     * When deserialize ExtendedObjectWithPrivate then private goes to parent
     * @test
     * @throws \Exception
     */
    public function testNestedPrivateProperty()
    {
        $data = [
            'property1' => 'property1',
        ];

        $unserializer = new AntyIntruder();
        $config = [
            'class' => ExtendedObjectWithPrivate::class
        ];
        /** @var ExtendedObjectWithPrivate $object */
        $object = $unserializer->unserialize($data, $config);
        $expected = new ExtendedObjectWithPrivate();

        $this->assertEquals($expected, $object);
        $exists = property_exists($object, 'property1');

        $this->assertFalse($exists);
        $this->assertEquals('property1', $object->getProperty1());
    }

//    /**
//     * Proves private property in nested class works fine
//     * When deserialize ExtendedObjectWithPrivate then private goes to parent
//     * @test
//     * @throws \Exception
//     */
//    public function testNestedPrivatePropertyDouble()
//    {
//        $data = [
//            'property1' => 'property1',
//            'property2' => 'property2',
//        ];
//
//        $unserializer = new AntyIntruder();
//        $config = [
//            'class' => ExtendedObjectWithPrivate::class
//        ];
//        /** @var ExtendedObjectWithPrivate $object */
//        $object = $unserializer->unserialize($data, $config);
//        $expected = new ExtendedObjectWithPrivate('property1', 'property2');
//
//        $this->assertEquals($expected, $object);
//        $exists = property_exists($object, 'property1');
//
//        $this->assertFalse($exists);
//        $this->assertEquals('property1', $object->getProperty1());
//    }
//
////    public function testTestTest()
////    {
////        $data = json_decode('{"prototypes":[],"profileGuid":null,"specificationGuid":"9953d92e-c615-4b7d-8fcd-a1a9e209e69d","profileFieldsNames":[],"specificationFieldsNames":["name"],"variantFeatures":[],"variantValues":{"new-sku":{"specificationFieldsNames":["name"],"values":{"name":[{"type":"text","value":"Variant name","languageData":[],"prefix":"","originalPrefix":"","unitSymbol":null}]},"languageCodes":["en"],"aliases":[],"symbols":[]}},"events":[],"productGuid":"f6bfdd5c-3ff7-44ce-8f7e-1e4a5fbcc460","values":{"name":[{"type":"text","value":"Product name","languageData":[],"prefix":"","originalPrefix":"","unitSymbol":null}]},"languageCodes":["en"],"aliases":[],"symbols":[]}', true);
////        $repository = new Repository(new EventBus(new Collector([])), new Intruder(), new InMemoryDataStore());
////
////        $product = $repository->buildProduct($data);
////    }
//
//    public function testTestTest2()
//    {
//        $newData = [
//            2 => [
//                4 => [
//                    'name' => 'Awesome',
//                    'count' => [
//                        'list' => 5
//                    ]
//                ]
//            ]
//        ];
//
//        $config = [
//            'content' => [
//                'content' => [
//                    'class' => \stdClass::class,
//                    'content' => [
//                        'count' => [
//                            'class' => \stdClass::class
//                        ]
//                    ]
//                ]
//            ]
//        ];
//
//        $z = new \stdClass();
//        $z->name = 'Awesome';
//        $z->count = new \stdClass();
//        $z->count->list = 5;
//        $expected[2][4] = $z;
//
//        $antyIntruder = new AntyIntruder();
//        $result = $antyIntruder->unserialize($newData, $config);
//        $this->assertEquals($expected, $result);
//    }
//
//    public function testTest3()
//    {
//        $data = [
//            'symbol' => 'symbol-name'
//        ];
//
//        $config = [
//            'class' => FieldSymbol::class,
//            'symbol' => [
//                'class' => FieldSymbol::class
//            ]
//        ];
//
//        $antyIntruder = new AntyIntruder();
//        $result = $antyIntruder->unserialize($data, $config);
//        $this->assertEquals(new FieldSymbol('symbol-name'), $result);
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testTest14(): void
//    {
//        $specification = new Specification('guid');
//        $specification->addField(new FieldSymbol('width'), new Config(1));
//        $inturder = new Intruder();
//        $specification->getUnpublishedEvents();
//        $data = $inturder->toArray($specification);
//
////        $data = [
////            'guid' => [
////                'guid' => 'guid'
////            ],
////            'aliases' => [
////                'width' => 'width'
////            ],
////            'configs' => [
////                'width' => [
////                    'isMandatory' => true,
////                    'alias' => 'width',
////                    'limit' => 1
////                ]
////            ]
////        ];
//
//        $config = [
//            'class' => Specification::class,
//            'content' => [
//                'fieldSymbols' => [
//                    'class' => FieldSymbolsCollection::class,
//                    'content' => [
//                        'items' => [
//                            'content' => [
//                                'class' => FieldSymbol::class
//                            ]
//                        ]
//                    ]
//                ],
//                'guid' => ['class' => Guid::class],
//                'configs' => [
//                    'content' => [
//                        'class' => Config::class
//                    ]
//                ],
//            ],
//        ];
//
//
//        $antyIntruder = new AntyIntruder();
//
//        $result = $antyIntruder->unserialize($data, $config);
//        $this->assertEquals($specification, $result);
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testTest15(): void
//    {
//        $pfv = new ProductFieldsValues(new Guid('product-guid'), new LanguageCodesCollection(['en']));
//        $inturder = new Intruder();
//        $data = $inturder->toArray($pfv);
//
//        $config = [
//            'class' => ProductFieldsValues::class,
//            'content' => [
//                'productGuid' => ['class' => Guid::class],
//                'profileFieldsNames' => [
//                    'class' => FieldSymbolsCollection::class,
//                    'content' => [
//                        'items' => [
//                            'content' => [
//                                'class' => FieldSymbol::class
//                            ]
//                        ]
//                    ]
//                ],
//                'specificationFieldsNames' => [
//                    'class' => FieldSymbolsCollection::class,
//                    'content' => [
//                        'items' => [
//                            'content' => [
//                                'class' => FieldSymbol::class
//                            ]
//                        ]
//                    ]
//                ],
//                'variantFeatures' => [
//                    'class' => FieldSymbolsCollection::class,
//                    'content' => [
//                        'items' => [
//                            'content' => [
//                                'class' => FieldSymbol::class
//                            ]
//                        ]
//                    ]
//                ],
//                'languageCodes' => [
//                    'class' => LanguageCodesCollection::class,
//                    'content' => [
//                        'items' => [
//                            'content' => [
//                                'class' => LanguageCode::class
//                            ]
//                        ]
//                    ]
//                ]
//            ],
//        ];
//
//        $antyIntruder = new AntyIntruder();
//        $result = $antyIntruder->unserialize($data, $config);
//        $this->assertEquals($pfv, $result);
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testTest16(): void
//    {
//        $field = new \PIM\Domain\Field\Type\Integer\Field('name');
//        $inturder = new Intruder();
//        $field->getUnpublishedEvents();
//        $data = $inturder->toArray($field);
//
//        $factory = $this;
//        $config = [
//            'class' => function ($data) use ($factory) {
//                return $factory->buildValueClassName($data);
//            },
//            'content' => [
//                'symbol' => [
//                    'class' => FieldSymbol::class
//                ],
//                'constraints' => [
//                    'class' => function (array $data): string {
//                        return EmptyConstraints::class;
//                    }
//                ],
//                'valueType' => [
//                    'class' => ValueType::class
//                ]
//            ]
//        ];
//
//
//        $antyIntruder = new AntyIntruder();
//        $result = $antyIntruder->unserialize($data, $config);
//        $this->assertEquals($field, $result);
//    }
//
//    public function buildValueClassName(array $data): string
//    {
//        return \PIM\Domain\Field\Type\Integer\Field::class;
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testTest17(): void
//    {
//
//        $eventBus = new EventBus(new Collector([]));
//        $intruder = new Intruder();
//        $accessLayer = new InMemoryDataStore();
//        $fieldRepository = new \PIM\Domain\Field\Repository($eventBus, $intruder, new FieldFactory(), $accessLayer);
//        $unitRepository = new UnitRepository($eventBus, $intruder, $accessLayer);
//
//        $colorChoice = new FlatList('colors', null, new FlatListParameters('name'));
//        $fieldRepository->save(new Field('name'));
//
//        $colorTemplate = new ThingTemplate(new Guid('some-guid'));
//        Group::addField($colorTemplate, ['symbol' => 'name', 'isMandatory' => true]);
//
//        $values = new Values();
//        $values->add(new FieldSymbol('name'), new Value(['pl' => 'Czerwony', 'en' => 'Red']));
//        $red = $colorTemplate->create(
//            $fieldRepository,
//            $unitRepository,
//            $values,
//            new LanguageCodesCollection(['pl', 'en'])
//        );
//        $colorChoice->add('red', $red);
//        $fieldRepository->save($colorChoice);
//
//        $xxx = $fieldRepository->find($colorChoice->getSymbol());
//        $this->assertEquals($colorChoice, $xxx);
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testRecursive(): void
//    {
//        $data = [
//            'name' => 'test1',
//            'values' => [
//                [
//                    'name' => 'test2',
//                    'values' => [
//                        [
//                            'name' => 'test3',
//                            'values' => []
//                        ]
//                    ]
//                ]
//            ],
//        ];
//
//        $unserializer = new AntyIntruder();
//        $config = $this->getConfig()['content'];
//        $object = $unserializer->unserialize($data, $config);
//
//        $recursive0 = new Recursive('test1');
//        $recursive1 = new Recursive('test2');
//        $recursive2 = new Recursive('test3');
//        $recursive1->setItem($recursive2);
//        $recursive0->setItem($recursive1);
//
//        $this->assertEquals($recursive0, $object);
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function testRecursiveMoreDepth(): void
//    {
//        $data = [
//            'name' => 'test1',
//            'values' => [
//                [
//                    'name' => 'test2',
//                    'values' => [
//                        [
//                            'name' => 'test3',
//                            'values' => [
//                                [
//                                    'name' => 'test4',
//                                    'values' => [
//                                        [
//                                            'name' => 'test5',
//                                            'values' => []
//                                        ]
//
//                                    ]
//                                ]
//
//                            ]
//                        ]
//                    ]
//                ]
//            ],
//        ];
//
//        $unserializer = new AntyIntruder();
//        $config = $this->getConfig()['content'];
//        $object = $unserializer->unserialize($data, $config);
//
//        $recursive0 = new Recursive('test1');
//        $recursive1 = new Recursive('test2');
//        $recursive2 = new Recursive('test3');
//        $recursive3 = new Recursive('test4');
//        $recursive4 = new Recursive('test5');
//        $recursive3->setItem($recursive4);
//        $recursive2->setItem($recursive3);
//        $recursive1->setItem($recursive2);
//        $recursive0->setItem($recursive1);
//
//        $this->assertEquals($recursive0, $object);
//    }
//
//    private function getConfig(): array
//    {
//        $self = $this;
//        return [
//            'content' => [
//                'class' => Recursive::class,
//                'content' => [
//                    'values' => function () use ($self) {
//                        return $self->getConfig();
//                    }
//                ]
//            ]
//        ];
//    }
}