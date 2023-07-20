<?php

namespace App\Tests\App\Integration\DTO;

use App\DTO\PlantDTO;
use PHPUnit\Framework\TestCase;

class PlantDTOTest extends TestCase
{
    const PLANT_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    public function testShouldReturnPlantDTO()
    {
        $plantDTO = new PlantDTO(
            self::PLANT_ARRAY['id'],
            self::PLANT_ARRAY['name'],
            self::PLANT_ARRAY['type'],
            self::PLANT_ARRAY['quantity'],
            self::PLANT_ARRAY['unit']
        );

        $this->assertInstanceOf(PlantDTO::class, $plantDTO);
        $this->assertEquals(self::PLANT_ARRAY['id'], $plantDTO->getId());
        $this->assertEquals(self::PLANT_ARRAY['name'], $plantDTO->getName());
        $this->assertEquals(self::PLANT_ARRAY['type'], $plantDTO->getType());
        $this->assertEquals(self::PLANT_ARRAY['quantity'], $plantDTO->getQuantity());
        $this->assertEquals(self::PLANT_ARRAY['unit'], $plantDTO->getUnit());
    }
}
