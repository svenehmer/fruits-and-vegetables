<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\Plant\FruitCollection;
use App\Collection\Plant\VegetableCollection;
use App\Collection\PlantCollectionInterface;
use App\DTO\PlantDTO;
use App\Entity\Plant\Fruit;
use App\Entity\Plant\Vegetable;
use App\Entity\PlantInterface;
use App\Factory\PlantFactory;

class PlantService
{
    protected PlantFactory $plantFactory;

    /**
     * @var PlantCollectionInterface[]
     */
    protected array $plantCollections;

    public function __construct()
    {
        $this->plantFactory = new PlantFactory();
        $this->registerPlantCollections();
    }

    protected function registerPlantCollections(): void
    {
        $this->plantCollections = [
            Fruit::class => new FruitCollection(),
            Vegetable::class => new VegetableCollection(),
        ];
    }

    public function create(PlantDTO $plantDTO): PlantInterface
    {
        return $this->plantFactory->create($plantDTO);
    }

    public function add(PlantInterface $plant): void
    {
        $this->addToCollection($plant);
    }

    public function remove(PlantInterface $plant): void
    {
        $this->removeFromCollection($plant);
    }

    /**
     * List plant collections as array
     *
     * @param bool $convertToKG
     * @return array
     */
    public function list(bool $convertToKG = false): array
    {
        $list = [];

        /**
         * @var PlantCollectionInterface $plantCollection
         */
        foreach ($this->plantCollections as $plantCollection) {
            $list[$plantCollection->getType()] = $plantCollection->list($convertToKG);
        }

        return $list;
    }

    protected function addToCollection(PlantInterface $plant): void
    {
        $this->getCollection($plant)->add($plant);
    }

    protected function removeFromCollection(PlantInterface $plant): void
    {
        $this->getCollection($plant)->remove($plant->getId());
    }


    protected function getCollection(PlantInterface $plant): PlantCollectionInterface
    {
        return $this->plantCollections[$plant::class];
    }
}
