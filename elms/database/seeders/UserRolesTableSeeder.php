<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->truncate();
        $rows = [
            [
                'user_group_id' => 1,
                'menu_id' => 1,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],

            [
                'user_group_id' => 1,
                'menu_id' => 2,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 3,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 4,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 5,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 6,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,



            ],
            [
                'user_group_id' => 1,
                'menu_id' => 7,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 8,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 9,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 10,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 11,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 12,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,


            ],
            [
                'user_group_id' => 1,
                'menu_id' => 13,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 14,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 15,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 16,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 17,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 18,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 19,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 20,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 21,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 22,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 23,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 24,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],
            [
                'user_group_id' => 1,
                'menu_id' => 25,
                'allow_view' => 1,
                'allow_add' => 1,
                'allow_edit' => 1,
            ],

        ];
        DB::table('user_roles')->insert($rows);
    }
}
