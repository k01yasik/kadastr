<?php

namespace App\Imports;

interface StructureInterface
{
    public function getHouse(): string;

    public function getApartment(): string;

    public function getDelay(): int;

    public function getSettlementId(): ?string;

    public function getStreet(): ?string;
}