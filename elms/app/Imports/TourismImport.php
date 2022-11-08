<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class TourismImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            DB::table('tourism')->insert([
                'sn' => $row[0],
                'name_of_member_enterprises' => $row[2],
                'associated_association' => $row[3],
                'sector' => $row[4],
                'district' => $row[5],
                'local_level' => $row[6],
                'ward_no' => $row[7],
                'scale_of_industry' => $row[8],
                'contact_person' => $row[9],
                'contact_address' => $row[10],
                'contact_number' => $row[11],
                'email' => $row[14],
            ]);
        }
    }
}
