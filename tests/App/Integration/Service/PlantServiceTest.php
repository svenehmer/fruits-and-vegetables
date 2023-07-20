<?php

namespace App\Tests\App\Integration\Service;

use App\DTO\PlantDTO;
use App\Entity\AbstractPlant;
use App\Entity\Plant\Fruit;
use App\Service\PlantService;
use PHPUnit\Framework\TestCase;

class PlantServiceTest extends TestCase
{
    const FRUIT_UNIT_G_ARRAY = [
        'id' => 1,
        'name' => 'Apple',
        'type' => 'fruit',
        'quantity' => 10922,
        'unit' => 'g'
    ];

    public function testShouldImportFullRequestJson()
    {
        $requestJson = $this->getRequestJson();
        $plantsData = json_decode($requestJson, true);
        $plantService = new PlantService();

        foreach ($plantsData as $plantData) {
            $plantDTO = $this->getPlantDTO($plantData);
            $plant = $plantService->create($plantDTO);
            $plantService->add($plant);
        }

        $plantLists = $plantService->list();

        $this->assertIsArray($plantLists);
        $this->assertCount(2, $plantLists);

        $rawPlantsCount = count($plantsData);
        $processedPlantsCount = 0;
        foreach ($plantLists as $plantList) {
            $processedPlantsCount += count($plantList);
        }
        $this->assertEquals($rawPlantsCount, $processedPlantsCount);
    }

    public function testShouldListPlantsInKG()
    {
        $plantService = new PlantService();
        $plantDTO = $this->getPlantDTO(self::FRUIT_UNIT_G_ARRAY);
        $fruit = $plantService->create($plantDTO);
        $plantService->add($fruit);

        $plantLists = $plantService->list();
        $this->assertEquals(AbstractPlant::UNIT_G, $plantLists[Fruit::TYPE][self::FRUIT_UNIT_G_ARRAY['id']]['unit']);
        $this->assertEquals(
            self::FRUIT_UNIT_G_ARRAY['quantity'],
            $plantLists[Fruit::TYPE][self::FRUIT_UNIT_G_ARRAY['id']]['quantity']
        );


        $plantLists = $plantService->list(true);
        $this->assertEquals(AbstractPlant::UNIT_KG, $plantLists[Fruit::TYPE][self::FRUIT_UNIT_G_ARRAY['id']]['unit']);
        $this->assertEquals(
            self::FRUIT_UNIT_G_ARRAY['quantity'] / AbstractPlant::UNIT_G_KG_MULTIPLIER,
            $plantLists[Fruit::TYPE][self::FRUIT_UNIT_G_ARRAY['id']]['quantity']
        );
    }

    public function testShouldRemovePlantFromCollection()
    {
        $requestJson = $this->getRequestJson();
        $plantsData = json_decode($requestJson, true);
        $plantService = new PlantService();

        foreach ($plantsData as $plantData) {
            $plantDTO = $this->getPlantDTO($plantData);
            $plant = $plantService->create($plantDTO);
            $plantService->add($plant);
        }

        $plantLists = $plantService->list(true);
        $this->assertIsArray($plantLists);
        $rawPlantsCount = count($plantsData);
        $processedPlantsCountBeforeRemove = 0;
        foreach ($plantLists as $plantList) {
            $processedPlantsCountBeforeRemove += count($plantList);
        }
        $this->assertEquals($rawPlantsCount, $processedPlantsCountBeforeRemove);

        $plantService->remove($plant);
        $plantLists = $plantService->list(true);
        $processedPlantsCountAfterRemove = 0;
        foreach ($plantLists as $plantList) {
            $processedPlantsCountAfterRemove += count($plantList);
        }
        $this->assertEquals($processedPlantsCountBeforeRemove-1, $processedPlantsCountAfterRemove);
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

    protected function getRequestJson(): string
    {
        return file_get_contents(__DIR__.'/../../../fixtures/request.json');
    }
}
