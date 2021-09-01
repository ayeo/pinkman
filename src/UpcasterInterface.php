<?php

namespace Ayeo\Pinkman;

interface UpcasterInterface
{
    public function upcast(string $className, array $data, int $dataVersion, int $classVersion): array;
}
