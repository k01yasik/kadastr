<?php

namespace App\Imports;

use \GuzzleHttp\Client;

class Request 
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function makeRequest(StructureInterface $structure)
    {
        $query = $this->makeQuery($structure);        

        $response = $this->client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
            'query' => $query,
            'delay' => $structure->getDelay()
        ]);

        return $response;
    }

    private function makeQuery(StructureInterface $structure)
    {
        $query = [
            'macroRegionId' => '158000000000',
            'regionId' => '158229000000',
        ];

        $settlementId = $structure->getSettlementId();
        $street = $structure->getStreet();

        if ($settlementId) {
            $query['settlementId'] = $settlementId;
        }

        if ($street) {
            $query['street'] = $street;
        }

        $query['house'] = $structure->getHouse();
        $query['apartment'] = $structure->getApartment();

        return $query;
    }
}