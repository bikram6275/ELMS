<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->truncate();
        $rows=[
                [
                    'parent_id'=>0,
                    'qsn_number'=>'d',
                    'qsn_name'=>'Name of Chief Executive Officer',
                    'ans_type'=>'input',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'e',
                    'qsn_name'=>'Name of HR officer (If applicable)',
                    'ans_type'=>'input',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'f',
                    'qsn_name'=>'Registered with',
                    'ans_type'=>'checkbox',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'g',
                    'qsn_name'=>'Types of Enterprises',
                    'ans_type'=>'radio',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'h',
                    'qsn_name'=>'Number of partners/ Stakeholders',
                    'ans_type'=>'input',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'i',
                    'qsn_name'=>'Scale of enterprise',
                    'ans_type'=>'radio',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>0,
                    'qsn_number'=>'2',
                    'qsn_name'=>'Membership with Employers’ Association',
                    'ans_type'=>'other_values',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>7,
                    'qsn_number'=>'I',
                    'qsn_name'=>'Associated Federation',
                    'ans_type'=>'other_values',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>7,
                    'qsn_number'=>'II',
                    'qsn_name'=>'Associated district chapter',
                    'ans_type'=>'other_values',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],
                [
                    'parent_id'=>7,
                    'qsn_number'=>'III',
                    'qsn_name'=>'Associated commodity association',
                    'ans_type'=>'other_values',
                    'qst_status'=>'active',
                    'required'=>'yes',
                    'instruction'=>'',
                ],

        ];
        DB::table('questions')->insert($rows);

    }
}
