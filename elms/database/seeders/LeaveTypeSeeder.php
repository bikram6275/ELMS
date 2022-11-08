<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leave_type')->truncate();
        $leave_type = "INSERT INTO `leave_type` VALUES
        (1,'paid leave', '2018-01-24 02:56:20', NULL),
        (2,'Technical ',  '2018-01-24 02:57:34', NULL)";


        DB::select(DB::raw($leave_type));
    }
}
