<?php

namespace App\Tests\App\Integration\Collection\Plant;

use App\Collection\Plant\FruitCollection;
use App\Entity\AbstractPlant;
use App\Entity\Plant\Fruit;
use PHPUnit\Framework\TestCase;

class FruitCollectionTest extends TestCase
{
    const FRUIT_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    protected function getFruit(): Fruit
    {
        return new Fruit(
            self::FRUIT_ARRAY['id'],
            self::FRUIT_ARRAY['name'],
            self::FRUIT_ARRAY['quantity']
        );
    }

    public function testShouldAddFruitToCollection()
    {
        $fruitCollection = new FruitCollection();
        $fruit = $this->getFruit();

        $expectedResult = [
            self::FRUIT_ARRAY['id'] => [
                'id' => self::FRUIT_ARRAY['id'],
                'name' => self::FRUIT_ARRAY['name'],
                'type' => self::FRUIT_ARRAY['type'],
                'quantity' => self::FRUIT_ARRAY['quantity'],
                'unit' => AbstractPlant::UNIT_G
            ]
        ];

        $this->assertEmpty($fruitCollection->list());
        $fruitCollection->add($fruit);
        $result = $fruitCollection->list();
        $this->assertIsArray($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldRemoveFruitFromCollection()
    {
        $fruitCollection = new FruitCollection();
        $fruit = $this->getFruit();
        $expectedResult = [];

        $result = $fruitCollection->list();
        $this->assertEmpty($result);

        $fruitCollection->add($fruit);
        $this->assertNotEmpty($fruitCollection->list());

        $fruitCollection->remove($fruit->getId());
        $result = $fruitCollection->list();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldNotRemoveFruitFromCollection()
    {
        $fruitCollection = new FruitCollection();
        $fruit = $this->getFruit();
        $expectedResult = [
            self::FRUIT_ARRAY['id'] => [
                'id' => self::FRUIT_ARRAY['id'],
                'name' => self::FRUIT_ARRAY['name'],
                'type' => self::FRUIT_ARRAY['type'],
                'quantity' => self::FRUIT_ARRAY['quantity'],
                'unit' => AbstractPlant::UNIT_G
            ]
        ];

        $fruitCollection->add($fruit);
        $result = $fruitCollection->list();
        $this->assertNotEmpty($result);

        $notExistingFruitId = 1337;
        $fruitCollection->remove($notExistingFruitId);
        $result = $fruitCollection->list();
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals($expectedResult, $result);
    }

    public function testShouldConvertFruitQuantityToKG()
    {
        $fruitCollection = new FruitCollection();
        $fruit = $this->getFruit();
        $fruitCollection->add($fruit);
        $list = $fruitCollection->list(true);

        $this->assertIsArray($list);
        $this->assertEquals(AbstractPlant::UNIT_KG, $list[self::FRUIT_ARRAY['id']]['unit']);
        $this->assertEquals(
            self::FRUIT_ARRAY['quantity'] / AbstractPlant::UNIT_G_KG_MULTIPLIER,
            $list[self::FRUIT_ARRAY['id']]['quantity']
        );
    }
}
