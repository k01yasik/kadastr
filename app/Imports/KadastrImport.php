<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Imports\Request;
use \GuzzleHttp\Client;

class KadastrImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $client = new Client();

        $request = new Request($client);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach ($rows as $row)
        {
            if (strval($row[5]) === 'Приозерный') {
                $response = $request->makeRequest(new VillageStructure(strval($row[7]), strval($row[8]), '158229840034'));
            } else if (strval($row[5]) === 'Крулихино') {
                $response = $request->makeRequest(new VillageStructure(strval($row[7]), strval($row[8]), '158229805008'));
            } else if (strval($row[5]) === 'Духново') {
                $response = $request->makeRequest(new VillageStructure(strval($row[7]), strval($row[8]), '158229815001'));
            } else if (strval($row[5]) === 'Бездедово') {
                $response = $request->makeRequest(new VillageStructure(strval($row[7]), strval($row[8]), '158229835002'));                
            } else {
                $response = $request->makeRequest(new TownStructure(strval($row[9]), strval($row[10]), strval($row[7])));                
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
