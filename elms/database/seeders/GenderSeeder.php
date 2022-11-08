<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->truncate();
        $genders = "INSERT INTO `genders` VALUES
        (1,'Male', 'active', NULL, NULL),
        (2,'Female', 'active', NULL, NULL),
        (3,'Other', 'active', NULL, NULL)
        ";
        DB::statement($genders);
    }
}
