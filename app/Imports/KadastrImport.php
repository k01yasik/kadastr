<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KadastrImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $client = new \GuzzleHttp\Client();

        foreach ($rows as $row)
        {
            print_r($row);

            $response = $client->request('POST', 'http://rosreestr.ru/api/online/address/fir_objects', [
                'form_params' => [
                    'macroRegionId' => '158000000000',
                    'regionId' => '158229000000',
                    'street' => $row[7],
                    'house' => $row[9],
                    'apartment' => $row[10]
                ]
            ]);

            dd($response->getBody());
        }
    }
}