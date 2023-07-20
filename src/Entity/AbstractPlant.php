<?php

declare(strict_types=1);

namespace App\Entity;

abstract class AbstractPlant implements PlantInterface
{
    const UNIT_G = 'g';
    const UNIT_KG = 'kg';
    const UNIT_G_KG_MULTIPLIER = 1000;
    const TYPE = 'plant';

    protected string $unit = self::UNIT_G;
    protected string $type = self::TYPE;

    /**
     * @param int $id
     * @param string $name
     * @param int $quantity
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $quantity,
    ) {}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    public function toArray(bool $convertToKG = false): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'quantity' => $convertToKG ? $this->getQuantityInKG() : $this->getQuantity(),
            'unit' => $convertToKG ? self::UNIT_KG : $this->getUnit()
        ];
    }

    /**
     * @return int|float
     */
    protected function getQuantityInKG(): int|float
    {
        return $this->quantity / self::UNIT_G_KG_MULTIPLIER;
    }
}
