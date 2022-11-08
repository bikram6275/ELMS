<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\GenderSeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\CountrySeeder;
use Database\Seeders\PradeshSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\MuniTypeSeeder;
use Database\Seeders\MenusTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\MunicipalitySeeder;
use Database\Seeders\NepaliMonthsSeeder;
use Database\Seeders\CalenderTableSeeder;
use Database\Seeders\QuestionTableSeeder;
use Database\Seeders\UserRolesTableSeeder;
use Database\Seeders\UserGroupsTableSeeder;
use Database\Seeders\FiscalYearsTableSeeder;
use Database\Seeders\DesignationsTableSeeder;
use Database\Seeders\QuestionOptionsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call([
            MenusTableSeeder::class,
            //   DesignationsTableSeeder::class,
            //   UserGroupsTableSeeder::class,
            //   FiscalYearsTableSeeder::class,
            //   UsersTableSeeder::class,
            //   UserRolesTableSeeder::class,
            //    CountrySeeder::class,
            //   PradeshSeeder::class,
            //   DistrictSeeder::class,
            //   MuniTypeSeeder::class,
            //   MunicipalitySeeder::class,
            //    GenderSeeder::class,
            //    EducationLevelSeeder::class,
            //    EducationTypeSeeder::class,
            //    EmploymentTypeSeeder::class,
            //    ExperienceTagSeeder::class,
            //     LeaveTypeSeeder::class,
            //     Responsibility::class,
            // NepaliYearsSeeder::class,
            // NepaliMonthsSeeder::class
        ]);
    }
}
