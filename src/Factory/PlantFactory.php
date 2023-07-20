<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\PlantDTO;
use App\Entity\Plant\Fruit;
use App\Entity\Plant\Vegetable;
use App\Entity\PlantInterface;
use App\Normalizer\PlantNormalizer;

class PlantFactory
{
    protected PlantNormalizer $plantNormalizer;
    protected array $plantEntities = [
        Fruit::TYPE => Fruit::class,
        Vegetable::TYPE => Vegetable::class
    ];

    public function __construct()
    {
        $this->plantNormalizer = new PlantNormalizer();
    }

    public function create(PlantDTO $plantDTO): PlantInterface
    {
        $this->plantNormalizer->normalize($plantDTO);
        $plantClass = $this->getEntityClass($plantDTO->getType());

        return new $plantClass(
            $plantDTO->getId(),
            $plantDTO->getName(),
            $plantDTO->getQuantity()
        );
    }

    protected function getEntityClass(string $type): ?string
    {
        return $this->plantEntities[$type];
    }
}
