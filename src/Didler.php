<?php declare(strict_types=1);

namespace Ayeo\Didler;

class Didler
{
    /** @var Distillator */
    private $distillator;
    /** @var Hydrator */
    private $hydrator;

    public function __construct()
    {
        $this->distillator = new Distillator();
        $this->hydrator = new Hydrator();
    }

    public function distill(object $object, bool $filterEmpty = false): array
    {
        $result = $this->distillator->process($object);

        if ($filterEmpty) {
            return $this->filterEmpty($result);
        }

        return $result;
    }

    public function hydrate(array $data, array $config): object
    {
        return $this->hydrator->process($data, $config);
    }

    private function filterEmpty(array $data): array
    {
        foreach ($data as $key => $item) {
            if (is_null($item)) {
                unset($data[$key]);
            } elseif (is_array($item)) {
                if (count($item) === 0) {
                    unset($data[$key]);
                } else {
                    $data[$key] = $this->filterEmpty($data[$key]);
                }
            }
        }

        return $data;
    }
}
