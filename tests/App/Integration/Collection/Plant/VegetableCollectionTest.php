<?php

namespace App\Tests\App\Integration\Collection\Plant;

use App\Collection\Plant\VegetableCollection;
use App\Entity\AbstractPlant;
use App\Entity\Plant\Vegetable;
use PHPUnit\Framework\TestCase;

class VegetableCollectionTest extends TestCase
{
    const VEGETABLE_ARRAY = [
        'id' => 1,
        'name' => 'Carrot',
        'type' => 'vegetable',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    protected function getVegetable(): Vegetable
    {
        return new Vegetable(
            self::VEGETABLE_ARRAY['id'],
            self::VEGETABLE_ARRAY['name'],
            self::VEGETABLE_ARRAY['quantity']
        );
    }

    public function testShouldAddVegetableToCollection()
    {
        $vegetableCollection = new VegetableCollection();
        $vegetable = $this->getVegetable();

        $expectedResult = [
            self::VEGETABLE_ARRAY['id'] => [
                'id' => self::VEGETABLE_ARRAY['id'],
                'name' => self::VEGETABLE_ARRAY['name'],
                'type' => self::VEGETABLE_ARRAY['type'],
                'quantity' => self::VEGETABLE_ARRAY['quantity'],
                'unit' => AbstractPlant::UNIT_G
            ]
        ];

        $this->assertEmpty($vegetableCollection->list());
        $vegetableCollection->add($vegetable);
        $result = $vegetableCollection->list();
        $this->assertIsArray($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldRemoveVegetableFromCollection()
    {
        $vegetableCollection = new VegetableCollection();
        $vegetable = $this->getVegetable();
        $expectedResult = [];

        $result = $vegetableCollection->list();
        $this->assertEmpty($result);

        $vegetableCollection->add($vegetable);
        $this->assertNotEmpty($vegetableCollection->list());

        $vegetableCollection->remove($vegetable->getId());
        $result = $vegetableCollection->list();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldNotRemoveVegetableFromCollection()
    {
        $vegetableCollection = new VegetableCollection();
        $vegetable = $this->getVegetable();
        $expectedResult = [
            self::VEGETABLE_ARRAY['id'] => [
                'id' => self::VEGETABLE_ARRAY['id'],
                'name' => self::VEGETABLE_ARRAY['name'],
                'type' => self::VEGETABLE_ARRAY['type'],
                'quantity' => self::VEGETABLE_ARRAY['quantity'],
                'unit' => AbstractPlant::UNIT_G
            ]
        ];

        $vegetableCollection->add($vegetable);
        $result = $vegetableCollection->list();
        $this->assertNotEmpty($result);

        $notExistingVegetableId = 1337;
        $vegetableCollection->remove($notExistingVegetableId);
        $result = $vegetableCollection->list();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldConvertVegetableQuantityToKG()
    {
        $vegetableCollection = new VegetableCollection();
        $vegetable = $this->getVegetable();
        $vegetableCollection->add($vegetable);
        $list = $vegetableCollection->list(true);

        $this->assertIsArray($list);
        $this->assertEquals(AbstractPlant::UNIT_KG, $list[self::VEGETABLE_ARRAY['id']]['unit']);
        $this->assertEquals(
            self::VEGETABLE_ARRAY['quantity'] / AbstractPlant::UNIT_G_KG_MULTIPLIER,
            $list[self::VEGETABLE_ARRAY['id']]['quantity']
        );
    }
}
