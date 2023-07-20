<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\PlantInterface;

abstract class AbstractPlantCollection implements PlantCollectionInterface
{
    const TYPE = 'plant';
    protected string $type = self::TYPE;

    /**
     * @var PlantInterface[]
     */
    protected array $plants = [];

    /**
     * @param PlantInterface $plant
     * @return void
     */
    public function add(PlantInterface $plant): void
    {
        $this->plants[$plant->getId()] = $plant;
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        unset($this->plants[$id]);
    }

    /**
     * List plant collection as array
     *
     * @param bool $convertToKG
     * @return array
     */
    public function list(bool $convertToKG = false): array
    {
        return array_map(fn ($plant) => ($plant->toArray($convertToKG)), $this->plants);
    }

    /**
     * @return string
     */
    abstract public function getType(): string;
}
