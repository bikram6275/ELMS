<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class OrganizationImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // 0 => new ConstrunctionImport(),
            1 => new AgricultureImport(),
            // 2 => new TourismImport(),
     
        ];
    }
}
