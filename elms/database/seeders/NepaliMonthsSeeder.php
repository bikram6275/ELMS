<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NepaliMonthsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nepali_months')->truncate();
        $query = ("INSERT INTO `nepali_months`  VALUES
        (1,'Baishakh','active',NULL,NULL),
        (2,'Jestha','active',NULL,NULL),
        (3,'Ashadh','active',NULL,NULL),
        (4,'Shrawan','active',NULL,NULL),
        (5,'Bhadau','active',NULL,NULL),
        (6,'Ashwin','active',NULL,NULL),
        (7,'Kartik','active',NULL,NULL),
        (8,'Mangsir','active',NULL,NULL),
        (9,'Poush','active',NULL,NULL),
        (10,'Magh','active',NULL,NULL),
        (11,'Falgun','active',NULL,NULL),
        (12,'Chaitra','active',NULL,NULL)
        
        ");

        DB::statement($query);
    }
}
