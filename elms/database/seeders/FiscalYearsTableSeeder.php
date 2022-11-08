<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FiscalYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fiscal_years')->truncate();
        $rows = [
            [
                'fy_name' => '2020',
                'fy_start_date' => '2020-1-1',
                'fy_end_date' => '2020-12-30',


            ],


        ];
        DB::table('fiscal_years')->insert($rows);
    }
}
