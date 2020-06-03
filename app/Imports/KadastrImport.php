<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \GuzzleHttp\Client;

class KadastrImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $client = new Client();



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach ($rows as $row)
        {
            $col7 = strval($row[7]);
            $col8 = strval($row[8]);
            $col5 = strval($row[5]);
            $col9 = strval($row[9]);
            $col10 = strval($row[10]);

            if ($col5 === 'Приозерный') {
                $structure = new VillageStructure($col7, $col8, '158229840034');
            } else if ($col5 === 'Крулихино') {
                $structure = new VillageStructure($col7, $col8, '158229805008');
            } else if ($col5 === 'Духново') {
                $structure = new VillageStructure($col7, $col8, '158229815001');
            } else if ($col5 === 'Бездедово') {
                $structure = new VillageStructure($col7, $col8, '158229835002');
            } else {
                $structure = new TownStructure($col9, $col10, $col7);
            }

            $request = new Request($client, $structure);
            $request->init('158000000000', '158229000000');
            $request->setUrl('http://rosreestr.ru/api/online/address/fir_objects');
            $response = $request->makeRequest();

            $r = json_decode($response->getBody()->getContents(), true);

            if (is_array($r)) {
                $result = $r[0];
                $sheet->setCellValue('A'.$i, $result["addressNotes"]);
                $sheet->setCellValue('B'.$i, $result["nobjectCn"]);
            }

            $i++;
        }

        $writer = new Xlsx($spreadsheet);

        try {
            $writer->save('result.xlsx');
        } catch (Exception $e) {
        }
    }
}
