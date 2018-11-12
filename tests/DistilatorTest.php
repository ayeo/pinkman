<?php declare(strict_types=1);

namespace Ayeo\Pinkman\Tests;

use PHPUnit\Framework\TestCase;
use Ayeo\Pinkman\Distillator;
use Ayeo\Pinkman\Tests\Sample\NestedObject;
use Ayeo\Pinkman\Tests\Sample\ObjectWithArray;
use Ayeo\Pinkman\Tests\Sample\ObjectWithName;
use Ayeo\Pinkman\Tests\Sample\SampleClass;

class DistilatorTest extends TestCase
{
    private function getDistilator(): Distillator
    {
        return new Distillator();
    }

    /**
     * @throws \Exception
     */
    public function testFlat(): void
    {
        $testClass = new SampleClass();
        $expected = [
            'privateProperty' => 'private value',
            'protectedProperty' => 'protected value',
            'publicProperty' => 'public value'
        ];
        $this->assertEquals($expected, $this->getDistilator()->process($testClass));
    }

    /**
     * @throws \Exception
     */
    public function testNested(): void
    {
        $testClass = new NestedObject();
        $expected = [
            'name' => 'Name',
            'nested' => [
                'privateProperty' => 'private value',
                'protectedProperty' => 'protected value',
                'publicProperty' => 'public value'
            ]
        ];
        $this->assertEquals($expected, $this->getDistilator()->process($testClass));
    }

    /**
     * @throws \Exception
     */
    public function testObjectsArray(): void
    {
        $testClass = new ObjectWithArray();
        $testClass->add(new ObjectWithName('name a'));
        $testClass->add(new ObjectWithName('name b'));
        $testClass->add(new ObjectWithName('name c'));
        $expected = [
            'items' => [
                ['name' => 'name a'],
                ['name' => 'name b'],
                ['name' => 'name c'],
            ]
        ];
        $this->assertEquals($expected, $this->getDistilator()->process($testClass));
    }

    /**
     * @throws \Exception
     */
    public function testMixedArray(): void
    {
        $testClass = new ObjectWithArray();
        $testClass->add(new ObjectWithName('name a'));
        $testClass->add(12);
        $testClass->add([new ObjectWithName('nested'), 'pure string', 13.8]);
        $expected = [
            'items' => [
                ['name' => 'name a'],
                12,
                [
                    ['name' => 'nested'],
                    'pure string',
                    13.8
                ]
            ]
        ];
        $this->assertEquals($expected, $this->getDistilator()->process($testClass));
    }

//    public function testPrivateParentProperty()
//    {
//        $testClass = new Child();
//        $intruder = new Intruder();
//
//        $expected = [
//            'topSecret' => 'Nobody knows',
//            'childValue' => 'Child secret',
//            'secret' => 'The mystery'
//        ];
//
//        $this->assertEquals($expected, $intruder->toArray($testClass));
//    }
//
//    public function testNestedClassesAsProperty()
//    {
//        $testClass = new NestedAsProperty();
//        $intruder = new Intruder();
//
//        $expected = [
//            'nested' => [
//                'topSecret' => 'Nobody knows',
//                'childValue' => 'Child secret',
//                'secret' => 'The mystery'
//            ]
//        ];
//
//        $this->assertEquals($expected, $intruder->toArray($testClass));
//    }
//
//    public function testNestedClassesAsArrayItem()
//    {
//        $testClass = new NestedAsArrayItem();
//        $intruder = new Intruder();
//
//        $expected = [
//            'array' => [
//                [
//                    'topSecret' => 'Nobody knows',
//                    'childValue' => 'Child secret',
//                    'secret' => 'The mystery'
//                ],
//                [
//                    'topSecret' => 'Nobody knows',
//                    'childValue' => 'Child secret',
//                    'secret' => 'The mystery'
//                ],
//            ]
//
//        ];
//
//        $this->assertEquals($expected, $intruder->toArray($testClass));
//    }
}