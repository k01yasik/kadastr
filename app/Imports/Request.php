<?php

namespace App\Imports;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Request
{
    private Client $client;
    private StructureInterface $structure;
    private string $macro;
    private string $region;
    private string $url;

    public function __construct(Client $client, StructureInterface $structure)
    {
        $this->client = $client;
        $this->structure = $structure;
    }

    public function init(string $macro, string $region)
    {
        $this->macro = $macro;
        $this->region = $region;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public function makeRequest()
    {
        $query = $this->makeQuery();

        try {
            $response = $this->client->request('GET', $this->url, [
                'query' => $query,
                'delay' => $this->structure->getDelay()
            ]);
        } catch (GuzzleException $e) {
        }

        return $response;
    }

    private function makeQuery()
    {
        $query = [
            'macroRegionId' => $this->macro,
            'regionId' => $this->region,
        ];

        $settlementId = $this->structure->getSettlementId();
        $street = $this->structure->getStreet();

        if ($settlementId) {
            $query['settlementId'] = $settlementId;
        }

        if ($street) {
            $query['street'] = $street;
        }

        $query['house'] = $this->structure->getHouse();
        $query['apartment'] = $this->structure->getApartment();

        return $query;
    }
}
