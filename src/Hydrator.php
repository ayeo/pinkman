<?php declare(strict_types=1);

namespace Ayeo\Pinkman;

use ReflectionClass;

class Hydrator
{
    public function process(array $data, array $config, array $fullData = [])
    {
        $isCollection = is_array($data) && isset($config['class']) === false && isset($config['content']) === true;
        if ($isCollection) {
            foreach ($data as $key => $subset) {
                if (is_array($subset)) {
                    $cur = $this->buildContentArray($config['content'] ?? [], $subset, $fullData);
                    $value[$key] = $this->process($subset, $cur);
                } else {
                    $value[$key] = $this->buildValue($data, $config, $fullData);
                }
            }

            return $value ?? [];
        } else {
            if (isset($config['class'])) {
                return $this->buildValue($data, $config, $fullData);
            } else {
                $cur = $this->buildContentArray($config['content'] ?? [], $data, $fullData);
                return $this->buildValue($data, $cur);
            }
        }
    }

    private function buildValue($data, array $config, array $fullData = [])
    {
        if (isset($config['class'])) {
            $className = $config['class'];
            if (is_callable($className)) {
                $className = $className($data, $fullData);
            }
            $r = new ReflectionClass($className);
            $object = $r->newInstanceWithoutConstructor();

            if (is_array($data) === false) {
                return;
            }

            $cur = $this->buildContentArray($config['content'] ?? [], $data, $fullData);
            foreach ($data as $fieldName => $rawValue) {
                if (is_scalar($rawValue)) {
                    if (isset($cur[$fieldName])) {
                        $xx = $this->process($data, $cur[$fieldName]);
                        $this->setPrivateProperty($object, $fieldName, $xx);
                    } else {
                        $this->setPrivateProperty($object, $fieldName, $rawValue);
                    }
                } else {
                    $currentConfig = $cur[$fieldName] ?? [];
                    if (is_callable($currentConfig)) {
                        $currentConfig = $currentConfig();
                    }
                    if (isset($currentConfig['class']) && is_array($data[$fieldName])) {
                        $subValue = $this->process($data[$fieldName], $currentConfig, $data);
                        $this->setPrivateProperty($object, $fieldName, $subValue);
                        unset($subValue);
                    } elseif (($currentConfig['content'] ?? []) && count($data[$fieldName] ?? [])) {
                        $subValue = [];
                        if (isset($data[$fieldName]) === false) {
                            continue;
                        }

                        foreach ($data[$fieldName] ?? [] as $key => $subData) {
                            $x = $this->buildContentArray($currentConfig['content'], $subData, $fullData);
                            $subValue[$key] = $this->process($subData, $x);
                        }
                        $this->setPrivateProperty($object, $fieldName, $subValue);
                    } else {
                        $this->setPrivateProperty($object, $fieldName, $rawValue);
                    }
                }
            }

            return $object;
        } else {
            $subValue = [];
            foreach ($data as $fieldName2 => $rawValue2) {
                if (isset($config[$fieldName2])) {
                    $subValue[$fieldName2] = $this->process($data[$fieldName2], $config[$fieldName2]);
                } else {
                    $subValue[$fieldName2] = $rawValue2;
                }
            }

            return $subValue;
        }
    }

    private function setPrivateProperty(object $object, string $name, $value): void
    {
        if (is_null($value)) {
            return;
        }

        /**
         * stdClass throws exception on bindTo
         */
        if ($object instanceof \stdClass) {
            $object->$name = $value;
            return;
        }

        $x = function () use ($name, $value) {
            $properties = get_class_vars(get_class($this));
            if (array_key_exists($name, $properties)) {
                $this->$name = $value;
            }
        };

        $x->call($object);

        if ($parent = get_parent_class($object)) {
            $function = $x->bindTo($object, $parent);
            $function();
        }
    }

    private function buildContentArray($rawData = null, $data = null, $fullData = null): ?array
    {
        if (is_null($rawData) === false && is_callable($rawData)) {
            return $rawData($data, $fullData);
        } else {
            return $rawData;
        }
    }
}
