<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_education_types')->truncate();
        $employee_education_types = "INSERT INTO `employee_education_types` VALUES
        (1,'General', '2018-01-24 02:56:20', NULL),
        (2,'Technical ',  '2018-01-24 02:57:34', NULL),
        (3,'NSTB Certified ', '2018-01-24 02:58:05', NULL),
        (4,'RPL', '2018-01-24 02:58:31', NULL)";

        DB::select(DB::raw($employee_education_types));
    }
}
