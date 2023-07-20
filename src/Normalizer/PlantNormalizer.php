<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\DTO\PlantDTO;
use App\Entity\AbstractPlant;

class PlantNormalizer
{
    public function normalize(PlantDTO &$plantDTO): void
    {
        $this->normalizeQuantityUnit($plantDTO);
    }

    protected function normalizeQuantityUnit(PlantDTO &$plantDTO): void
    {
        if ($plantDTO->getUnit() === AbstractPlant::UNIT_KG) {
            $plantDTO->setQuantity($plantDTO->getQuantity() * AbstractPlant::UNIT_G_KG_MULTIPLIER);
            $plantDTO->setUnit(AbstractPlant::UNIT_G);
        }
    }
}
