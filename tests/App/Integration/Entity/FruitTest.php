<?php

namespace App\Tests\App\Integration\Entity;

use App\Entity\AbstractPlant;
use App\Entity\Plant\Fruit;
use PHPUnit\Framework\TestCase;

class FruitTest extends TestCase
{
    const FRUIT_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    public function testShouldReturnFruit()
    {
        $fruit = new Fruit(
            self::FRUIT_ARRAY['id'],
            self::FRUIT_ARRAY['name'],
            self::FRUIT_ARRAY['quantity']
        );

        $this->assertInstanceOf(Fruit::class, $fruit);
        $this->assertEquals(self::FRUIT_ARRAY['id'], $fruit->getId());
        $this->assertEquals(self::FRUIT_ARRAY['name'], $fruit->getName());
        $this->assertEquals(Fruit::TYPE, $fruit->getType());
        $this->assertEquals(self::FRUIT_ARRAY['quantity'], $fruit->getQuantity());
        $this->assertEquals(AbstractPlant::UNIT_G, $fruit->getUnit());
    }
}
