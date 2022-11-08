<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $rows = [

            [
                'user_group_id' => 1,
                'name' => 'Young Minds',
                'email' => 'developer@youngminds.com.np',
                'password' => bcrypt('ymc123'),
                'designation_id' => 1,
                'user_status' => 'active',
            ],
        ];
        DB::table('users')->insert($rows);
    }
}
