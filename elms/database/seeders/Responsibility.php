<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Responsibility extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('responsibilities')->truncate();
        $responsibilities = "INSERT INTO `responsibilities` VALUES
        (1,'Support Staffs', '2018-01-24 02:56:20', NULL),
        (2,'Admin/Account', '2018-01-24 02:56:20', NULL),
        (3,'Skill Worker', '2018-01-24 02:56:20', NULL),
        (4,'Technician ',  '2018-01-24 02:57:34', NULL),
        (5,'DOH', '2018-01-24 02:56:20', NULL),
        (6,'Management Level', '2018-01-24 02:56:20', NULL)";


        DB::select(DB::raw($responsibilities));
    }
}
