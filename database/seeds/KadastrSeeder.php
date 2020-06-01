<?php

use Illuminate\Database\Seeder;
use App\Imports\KadastrImport;
use Maatwebsite\Excel\Facades\Excel;

class KadastrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new KadastrImport, 'razobrannyi-file.xlsx');
    }
}
