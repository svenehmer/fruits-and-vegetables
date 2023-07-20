<?php

namespace App\Tests\App\Integration\Normalizer;

use App\DTO\PlantDTO;
use App\Entity\AbstractPlant;
use App\Normalizer\PlantNormalizer;
use PHPUnit\Framework\TestCase;

class PlantNormalizerTest  extends TestCase
{
    const VEGETABLE_UNIT_KG_ARRAY = [
        'id' => 1,
        'name' => 'Carrot',
        'type' => 'vegetable',
        'quantity' => 10922,
        'unit' => 'kg'
    ];

    const FRUIT_UNIT_G_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 123,
        'unit' => 'g'
    ];

    public function testShouldConvertQuantityToGram()
    {
        $plantNormalizer = new PlantNormalizer();
        $plantDTO = $this->getPlantDTO(self::VEGETABLE_UNIT_KG_ARRAY);

        $expectedPlantDTO = new PlantDTO(
            self::VEGETABLE_UNIT_KG_ARRAY['id'],
            self::VEGETABLE_UNIT_KG_ARRAY['name'],
            self::VEGETABLE_UNIT_KG_ARRAY['type'],
            self::VEGETABLE_UNIT_KG_ARRAY['quantity'] * AbstractPlant::UNIT_G_KG_MULTIPLIER,
            AbstractPlant::UNIT_G
        );

        $plantNormalizer->normalize($plantDTO);
        $this->assertEquals($expectedPlantDTO, $plantDTO);
    }

    public function testShouldNotConvertAlreadyNormalizedQuantity()
    {
        $plantNormalizer = new PlantNormalizer();
        $plantDTO = $this->getPlantDTO(self::FRUIT_UNIT_G_ARRAY);

        $expectedPlantDTO = new PlantDTO(
            self::FRUIT_UNIT_G_ARRAY['id'],
            self::FRUIT_UNIT_G_ARRAY['name'],
            self::FRUIT_UNIT_G_ARRAY['type'],
            self::FRUIT_UNIT_G_ARRAY['quantity'],
            AbstractPlant::UNIT_G
        );

        $plantNormalizer->normalize($plantDTO);
        $this->assertEquals($expectedPlantDTO, $plantDTO);
    }

    protected function getPlantDTO(array $plantData): PlantDTO
    {
        return new PlantDTO(
            $plantData['id'],
            $plantData['name'],
            $plantData['type'],
            $plantData['quantity'],
            $plantData['unit']
        );
    }
}
