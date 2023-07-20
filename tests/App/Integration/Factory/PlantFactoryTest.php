<?php

namespace App\Tests\App\Integration\Factory;

use App\DTO\PlantDTO;
use App\Entity\AbstractPlant;
use App\Entity\Plant\Fruit;
use App\Entity\Plant\Vegetable;
use App\Factory\PlantFactory;
use PHPUnit\Framework\TestCase;

class PlantFactoryTest extends TestCase
{
    const VALID_FRUIT_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    const VALID_VEGETABLE_ARRAY = [
        'id' => 1,
        'name' => 'Carrot',
        'type' => 'vegetable',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    const VALID_VEGETABLE_UNIT_GK_ARRAY = [
        'id' => 1,
        'name' => 'Carrot',
        'type' => 'vegetable',
        'quantity' => 10922,
        'unit' => 'kg'
    ];

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

    public function testCreateFruitEntity()
    {
        $plantFactory = new PlantFactory();
        $plantDTO = $this->getPlantDTO(self::VALID_FRUIT_ARRAY);

        $expectedFruit = new Fruit(
            self::VALID_FRUIT_ARRAY['id'],
            self::VALID_FRUIT_ARRAY['name'],
            self::VALID_FRUIT_ARRAY['quantity']
        );

        $fruit = $plantFactory->create($plantDTO);

        $this->assertInstanceOf(Fruit::class, $fruit);
        $this->assertEquals($expectedFruit, $fruit);
    }

    public function testCreateVegetableEntity()
    {
        $plantFactory = new PlantFactory();
        $plantDTO = $this->getPlantDTO(self::VALID_VEGETABLE_ARRAY);

        $expectedVegetable = new Vegetable(
            self::VALID_VEGETABLE_ARRAY['id'],
            self::VALID_VEGETABLE_ARRAY['name'],
            self::VALID_VEGETABLE_ARRAY['quantity']
        );

        $vegetable = $plantFactory->create($plantDTO);

        $this->assertInstanceOf(Vegetable::class, $vegetable);
        $this->assertEquals($expectedVegetable, $vegetable);
    }

    public function testCreateNormalizedVegetableEntity()
    {
        $plantFactory = new PlantFactory();
        $plantDTO = $this->getPlantDTO(self::VALID_VEGETABLE_UNIT_GK_ARRAY);

        $expectedVegetable = new Vegetable(
            self::VALID_VEGETABLE_ARRAY['id'],
            self::VALID_VEGETABLE_ARRAY['name'],
            self::VALID_VEGETABLE_ARRAY['quantity'] * AbstractPlant::UNIT_G_KG_MULTIPLIER
        );

        $vegetable = $plantFactory->create($plantDTO);

        $this->assertInstanceOf(Vegetable::class, $vegetable);
        $this->assertEquals($expectedVegetable, $vegetable);
    }
}
