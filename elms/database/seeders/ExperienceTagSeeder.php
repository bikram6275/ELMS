<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ExperienceTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('experience_tags')->truncate();
        $experience_tags = "INSERT INTO `experience_tags` VALUES
        (1,'In the Present Organisation', '2018-01-24 02:56:20', NULL),
        (2,'In the same Occupation ',  '2018-01-24 02:57:34', NULL),
        (3,'At Present Position ', '2018-01-24 02:58:05', NULL),
        (4,'In Other Organisation ', '2018-01-24 02:58:31', NULL),
        (5, 'Total Experience', '2018-01-24 02:59:18', NULL)
        ";

        DB::select(DB::raw($experience_tags));
    }
}
