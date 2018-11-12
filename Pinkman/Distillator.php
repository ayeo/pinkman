<?php declare(strict_types=1);

namespace Ayeo\Pinkman;

class Distillator
{
    /**
     * todo: method must detect if any class overwrites private properties (using same property name)
     */
    public function process(object $victim): array
    {
        $result = [];
        $parents = array_merge([get_class($victim)], $this->getParentClasses($victim));
        foreach ($parents as $parent) {
            $result = array_merge($result, array_merge($result, $this->getOneLevel($victim, $parent)));
        }
        return $result;
    }

    private function getOneLevel(object $victim, string $parent): array
    {
        $result = [];
        foreach ($this->getProperties($victim, $parent) as $propertyName) {
            $property = $this->getProperty($victim, $propertyName, $parent);
            $result[$propertyName] = $this->handle($property);
        }

        return $result;
    }

    private function handle($property)
    {
        if (is_object($property)) {
            return $this->process($property);
        }

        if (is_array($property)) {
            $tmp = [];
            foreach ($property as $key => $prop) {
                $tmp[$key] = $this->handle($prop);
            }

            return $tmp;
        }

        return $property;
    }

    private function getProperty(object $victim, string $propertyName, string $parentClass)
    {
        $closure = function () use ($propertyName) {
            return $this->{$propertyName};
        };

        return $closure->bindTo($victim, $parentClass)();
    }

    private function getProperties(object $victim, string $parent): array
    {
        $closure = function () {
            return get_object_vars($this);
        };
        $bind = $closure->bindTo($victim, $parent);

        return array_keys($bind());
    }

    private function getParentClasses($victim)
    {
        $parent = get_parent_class($victim);
        if ($parent) {
            return array_merge([$parent], $this->getParentClasses($parent));
        } else {
            return [];
        }
    }

    public function setStrings(array $classesToString)
    {
        $this->classesToString = $classesToString;
    }
}