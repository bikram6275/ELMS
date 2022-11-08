<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PradeshSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pradeshes')->truncate();
        $rows = [

            [
                'pradesh_name' => 'Pradesh-1'

            ],
            [
                'pradesh_name' => 'Pradesh-2'

            ],

            [
                'pradesh_name' => 'Pradesh-3',
            ],
            [
                'pradesh_name' => 'Pradesh-4'
            ],
            [
                'pradesh_name' => 'Pradesh-5'

            ],
            [
                'pradesh_name' => 'Pradesh-6'

            ],
            [
                'pradesh_name' => 'Pradesh-7'

            ]
        ];
        DB::table('pradeshes')->insert($rows);
    }
}
