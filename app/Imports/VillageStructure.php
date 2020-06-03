<?php

namespace App\Imports;

class VillageStructure implements StructureInterface
{
    private $house;
    private $apartment;
    private $settlementId;

    public function __construct(string $house, string $apartment, string $settlementId)
    {
        $this->house = $house;
        $this->apartment = $apartment;
        $this->settlementId = $settlementId;
    }

    public function getHouse(): string 
    {
        return $this->house;
    }

    public function getApartment(): string {
        return $this->apartment;
    }

    public function getDelay(): int {
        return 800;
    }

    public function getSettlementId(): ?string {
        return $this->settlementId;
    }

    public function getStreet(): ?string {
        return false;
    }   
}