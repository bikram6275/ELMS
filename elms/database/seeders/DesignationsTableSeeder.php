<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designations')->truncate();
        $rows = [
            [
                'designation_name' => 'Programmer',
                'designation_short_name' => 'programmer'
            ],
            [
                'designation_name' => 'Manager',
                'designation_short_name' => 'manager'
            ],
            [
                'designation_name' => 'CEO',
                'designation_short_name' => 'ceo'
            ],
            [
                'designation_name' => 'Designer',
                'designation_short_name' => 'designer'
            ]

        ];
        DB::table('designations')->insert($rows);
    }
}
