<?php

namespace App\Collection\Plant;

use App\Collection\AbstractPlantCollection;
use App\Entity\Plant\Vegetable;

class VegetableCollection extends AbstractPlantCollection
{
    const TYPE = Vegetable::TYPE;

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
