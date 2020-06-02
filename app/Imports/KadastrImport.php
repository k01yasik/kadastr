<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class KadastrImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $client = new \GuzzleHttp\Client();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach ($rows as $row)
        {
            if (strval($row[5]) === 'Приозерный') {
                $response = $client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
                    'query' => [
                        'macroRegionId' => '158000000000',
                        'regionId' => '158229000000',
                        'settlementId' => '158229840034',
                        'house' => strval($row[7]),
                        'apartment' => strval($row[8])
                    ],
                    'delay' => 800
                ]);
            } else if (strval($row[5]) === 'Крулихино') {
                $response = $client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
                    'query' => [
                        'macroRegionId' => '158000000000',
                        'regionId' => '158229000000',
                        'settlementId' => '158229805008',
                        'house' => strval($row[7]),
                        'apartment' => strval($row[8])
                    ],
                    'delay' => 800
                ]);
            } else if (strval($row[5]) === 'Духново') {
                $response = $client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
                    'query' => [
                        'macroRegionId' => '158000000000',
                        'regionId' => '158229000000',
                        'settlementId' => '158229815001',
                        'house' => strval($row[7]),
                        'apartment' => strval($row[8])
                    ],
                    'delay' => 800
                ]);
            } else if (strval($row[5]) === 'Бездедово') {
                $response = $client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
                    'query' => [
                        'macroRegionId' => '158000000000',
                        'regionId' => '158229000000',
                        'settlementId' => '158229835002',
                        'house' => strval($row[7]),
                        'apartment' => strval($row[8])
                    ],
                    'delay' => 800
                ]);
            } else {
                $response = $client->request('GET', 'http://rosreestr.ru/api/online/address/fir_objects', [
                    'query' => [
                        'macroRegionId' => '158000000000',
                        'regionId' => '158229000000',
                        'street' => strval($row[7]),
                        'house' => strval($row[9]),
                        'apartment' => strval($row[10])
                    ],
                    'delay' => 800
                ]);
            }            

            $r = json_decode($response->getBody()->getContents(), true);

            if (is_array($r)) {
                $result = $r[0];
                $sheet->setCellValue('A'.$i, $result["addressNotes"]);
                $sheet->setCellValue('B'.$i, $result["nobjectCn"]);
            }

            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('result.xlsx');
    }
}
