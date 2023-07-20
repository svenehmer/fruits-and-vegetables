<?php

namespace App\Entity\Plant;

use App\Entity\AbstractPlant;

class Vegetable extends AbstractPlant
{
    const TYPE = 'vegetable';

    protected string $type = self::TYPE;
}
