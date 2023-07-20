<?php

namespace App\Collection\Plant;

use App\Collection\AbstractPlantCollection;
use App\Entity\Plant\Fruit;

class FruitCollection extends AbstractPlantCollection
{
    const TYPE = Fruit::TYPE;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
