<?php

namespace App\Imports;

class TownStructure implements StructureInterface
{
    private $house;
    private $apartment;
    private $street;

    public function __construct(string $house, string $apartment, string $street)
    {
        $this->house = $house;
        $this->apartment = $apartment;
        $this->street = $street;
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
        return false;
    }

    public function getStreet(): ?string {
        return $this->street;
    }   
}