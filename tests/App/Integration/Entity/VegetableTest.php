<?php

namespace App\Tests\App\Integration\Entity;

use App\Entity\AbstractPlant;
use App\Entity\Plant\Vegetable;
use PHPUnit\Framework\TestCase;

class VegetableTest extends TestCase
{
    const VEGETABLE_ARRAY = [
        'id' => 1,
        'name' => 'Carrot',
        'type' => 'vegetable',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    public function testShouldReturnVegetable()
    {
        $vegetable = new Vegetable(
            self::VEGETABLE_ARRAY['id'],
            self::VEGETABLE_ARRAY['name'],
            self::VEGETABLE_ARRAY['quantity']
        );

        $this->assertInstanceOf(Vegetable::class, $vegetable);
        $this->assertEquals(self::VEGETABLE_ARRAY['id'], $vegetable->getId());
        $this->assertEquals(self::VEGETABLE_ARRAY['name'], $vegetable->getName());
        $this->assertEquals(Vegetable::TYPE, $vegetable->getType());
        $this->assertEquals(self::VEGETABLE_ARRAY['quantity'], $vegetable->getQuantity());
        $this->assertEquals(AbstractPlant::UNIT_G, $vegetable->getUnit());
    }
}
