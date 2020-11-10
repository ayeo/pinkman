<?php

declare(strict_types=1);

namespace Ayeo\Pinkman;

class Distillator
{
    /**
     * todo: method must detect if any class overwrites private properties (using same property name)
     */
    public function process(object $victim, array $config = []): array
    {
        $result = [];
        $parents = array_merge([get_class($victim)], $this->getParentClasses($victim));
        foreach ($parents as $parent) {
            $result = array_merge($result, array_merge($result, $this->getOneLevel($victim, $parent, $config)));
        }
        return $result;
    }

    private function getOneLevel(object $victim, string $parent, array $config): array
    {
        $result = [];
        foreach ($this->getProperties($victim, $parent) as $propertyName) {
            if (isset($config['unaryVO'])) {
                return ['vo' => (string)$victim];
            }

            if (isset($config['content']) && is_callable($config['content'])) {
                $closure = $config['content'];
                $config['content'] = $closure($this->handle($victim, []));
            }

            if (isset($config['content'][$propertyName]) && $config['content'][$propertyName] === false) {
                continue;
            }

            $property = $this->getProperty($victim, $propertyName, $parent, $config['content'] ?? []);
            $result[$propertyName] = $this->handle($property, $config['content'][$propertyName] ?? []);
        }

        return $result;
    }

    private function handle($property, $config)
    {
        if (is_object($property)) {
            return $this->process($property, $config);
        }

        $c = $config['content'] ?? [];
        if (is_array($property)) {
            $tmp = [];
            foreach ($property as $key => $prop) {
                if (is_callable($c)) {
                    $c = $c($this->handle($prop, []));
                }
                $tmp[$key] = $this->handle($prop, $c);
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