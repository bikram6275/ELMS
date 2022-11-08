<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_education_levels')->truncate();
        $employee_education_levels = "INSERT INTO `employee_education_levels` VALUES
        (1,'1','PhD', '2018-01-24 02:56:20', NULL),
        (2,1,'Masters',  '2018-01-24 02:57:34', NULL),
        (3,1,'Bachelor', '2018-01-24 02:58:05', NULL),
        (4,1,'+2 Level', '2018-01-24 02:58:31', NULL),
        (5,1,'SLC/SEE', '2018-01-24 02:59:18', NULL),
        (6,1,'Below SLC', '2018-01-24 02:58:31', NULL),
        (7,2,'PhD','2018-01-24 02:56:20', NULL),
        (8,2,'M. Tech.', '2018-01-24 02:58:31', NULL),
        (9,2,'Bachelor/B. Tech.', '2018-01-24 02:58:31', NULL),
        (10,2,'Diploma', '2018-01-24 02:58:31', NULL),
        (11,2,'Pre Diploma', '2018-01-24 02:58:31', NULL),
        (12,3,'Level Four', '2018-01-24 02:58:31', NULL),
        (13,3,'Level Three', '2018-01-24 02:58:31', NULL),
        (14,3,'Level Two', '2018-01-24 02:58:31', NULL),
        (15,3,'Level One', '2018-01-24 02:58:31', NULL),
        (16,4,'Level One', '2018-01-24 02:58:31', NULL),
        (17,4,'Level Two', '2018-01-24 02:58:31', NULL)";

        DB::select(DB::raw($employee_education_levels));
    }
}
