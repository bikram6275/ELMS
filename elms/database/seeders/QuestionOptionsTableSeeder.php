<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_options')->truncate();
        $rows=[
            [
              'qsn_id'=>3,
              'option_number'=>'a',
              'option_name'=>'Office of Company Register',
              'option_order'=>'1',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>3,
              'option_number'=>'b',
              'option_name'=>'Cottage and Small Industry Office',
              'option_order'=>'2',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>3,
              'option_number'=>'c',
              'option_name'=>'Local Government (Municipality/R. Municipality)',
              'option_order'=>'3',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>3,
              'option_number'=>'d',
              'option_name'=>'District Coordination Committee',
              'option_order'=>'4',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>3,
              'option_number'=>'e',
              'option_name'=>'Others',
              'option_order'=>'5',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>4,
              'option_number'=>'a',
              'option_name'=>'Proprietorship',
              'option_order'=>'1',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>4,
              'option_number'=>'b',
              'option_name'=>'Partnership',
              'option_order'=>'2',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>4,
              'option_number'=>'c',
              'option_name'=>'Private Limited Company',
              'option_order'=>'3',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>4,
              'option_number'=>'d',
              'option_name'=>'Public Limited Company',
              'option_order'=>'4',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>4,
              'option_number'=>'e',
              'option_name'=>'State owned enterprises',
              'option_order'=>'5',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>6,
              'option_number'=>'a',
              'option_name'=>'Micro',
              'option_order'=>'1',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>6,
              'option_number'=>'b',
              'option_name'=>'Small',
              'option_order'=>'2',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>6,
              'option_number'=>'c',
              'option_name'=>'Medium',
              'option_order'=>'3',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>6,
              'option_number'=>'d',
              'option_name'=>'Large',
              'option_order'=>'4',
              'option_type'=>'input'
            ],
            [
              'qsn_id'=>8,
              'option_number'=>'a',
              'option_name'=>'FNCCI',
              'option_order'=>'1',
              'option_type'=>'json'
            ],
            [
              'qsn_id'=>8,
              'option_number'=>'b',
              'option_name'=>'FNCSI',
              'option_order'=>'2',
              'option_type'=>'json'
            ],
            [
              'qsn_id'=>8,
              'option_number'=>'c',
              'option_name'=>'CNI',
              'option_order'=>'3',
              'option_type'=>'json'
            ],
            [
              'qsn_id'=>8,
              'option_number'=>'d',
              'option_name'=>'FCAN',
              'option_order'=>'4',
              'option_type'=>'json'
            ],
            [
              'qsn_id'=>8,
              'option_number'=>'e',
              'option_name'=>'HAN',
              'option_order'=>'5',
              'option_type'=>'json'
            ],

            ];
            DB::table('question_options')->insert($rows);
    }
}
