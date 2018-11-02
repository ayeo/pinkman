<?php declare(strict_types=1);

namespace Ayeo\Didler\Tests;

use Ayeo\Didler\Distilator;
use Ayeo\Didler\Tests\Sample\NestedObject;
use Ayeo\Didler\Tests\Sample\SampleClass;
use PHPUnit\Framework\TestCase;

class DistilatorTest extends TestCase
{
    private function getDistilator(): Distilator
    {
        return new Distilator();
    }

    /**
     * @throws \Exception
     */
    public function testFlat(): void
    {
        $testClass = new SampleClass();
        $actual = $this->getDistilator()->process($testClass);
        $expected = [
            'privateProperty' => 'private value',
            'protectedProperty' => 'protected value',
            'publicProperty' => 'public value'
        ];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @throws \Exception
     */
    public function testNested(): void
    {
        $testClass = new NestedObject();
        $actual = $this->getDistilator()->process($testClass);
        $expected = [
            'name' => 'Name',
            'nested' => [
                'privateProperty' => 'private value',
                'protectedProperty' => 'protected value',
                'publicProperty' => 'public value'
            ]
        ];
        $this->assertEquals($expected, $actual);
    }
//
//    public function testObjectsArray()
//    {
//        $testClass = new ObjectWithArray();
//        $testClass->add(new ObjectWithName('name a'));
//        $testClass->add(new ObjectWithName('name b'));
//        $testClass->add(new ObjectWithName('name c'));
//
//        $intruder = new Intruder();
//        $actual = $intruder->toArray($testClass);
//
//        $expected = [
//            'items' => [
//                ['name' => 'name a'],
//                ['name' => 'name b'],
//                ['name' => 'name c'],
//            ]
//        ];
//
//        $this->assertEquals($expected, $actual);
//    }
//
//    public function testMixedArray()
//    {
//        $testClass = new ObjectWithArray();
//        $testClass->add(new ObjectWithName('name a'));
//        $testClass->add(12);
//        $testClass->add([new ObjectWithName('nested'), 'pure string', 13.8]);
//
//        $intruder = new Intruder();
//        $actual = $intruder->toArray($testClass);
//
//        $expected = [
//            'items' => [
//                ['name' => 'name a'],
//                12,
//                [
//                    ['name' => 'nested'],
//                    'pure string',
//                    13.8
//                ]
//            ]
//        ];
//
//        $this->assertEquals($expected, $actual);
//    }
//
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