<?php

namespace App\Entity\Plant;

use App\Entity\AbstractPlant;

class Fruit extends AbstractPlant
{
    const TYPE = 'fruit';

    protected string $type = self::TYPE;
}
