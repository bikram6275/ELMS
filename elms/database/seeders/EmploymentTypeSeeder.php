<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employment_types')->truncate();
        $employment_types = "INSERT INTO `employment_types` VALUES
        (1,'Seasonal', '2018-01-24 02:56:20', NULL),
        (2,'Daily Wages ',  '2018-01-24 02:57:34', NULL),
        (3,'Temporary ', '2018-01-24 02:58:05', NULL),
        (4,'Permanent', '2018-01-24 02:58:31', NULL),
        (5,'Consultancy', '2018-01-24 02:58:31', NULL)
        ";

        DB::select(DB::raw($employment_types));
    }
}
