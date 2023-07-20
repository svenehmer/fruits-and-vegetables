<?php

namespace App\Collection;

use App\Entity\PlantInterface;

interface PlantCollectionInterface
{
    public function add(PlantInterface $plant): void;

    public function remove(int $id): void;

    public function list(bool $convertToKG = false): array;

    public function getType(): string;
}
