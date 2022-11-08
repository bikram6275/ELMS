<?php

namespace App\Repository;



class DataRepository
{
    public static function humanResourceList()
    {
        $data = [
            'Employer',
            'Family Member',
            'Employees',
        ];
        return $data;
    }

    public static function humanResource()
    {
        $data = [
            'employer' => 'Employer',
            'family_member' => 'Family Member',
            'employees' => 'Employees',

       ];
       return $data;
    }


    public static function workersList()
    {
        $data = [
            'Managerial',
            'Technical',
            'Administrative',
            'Assisting',
        ];
        return $data;
    }
    public static function workers()
    {
        $data = [
            'managerial' => 'Managerial',
            'technical' => 'Technical',
            'administrative' => 'Administrative',
            'assisting' => 'Assisting',
        ];
        return $data;
    }

    public function ansType(){

        $data = [
            'input' => 'Input',
            'radio' => 'Radio',
            'checkbox' => 'CheckBox',
            'multiple_input' => 'Multiple Input',
            // 'table'=>'Table',
            'range'=>'Range',
            'other_values'=>'Other Values',
            'external_table'=>'External table',
            'sector'=>'Sector',
            'services'=>'Services',
            'sub_qsn'=>'Sub-Question',
            'cond_radio'=>'Conditional Radio',

        ];
        return $data;
    }

    public function optionType()
    {
       $data=[
           'json'=>'Json',
           'input'=>'Input',
           'radio'=>'Radio',
           'checkbox'=>'CheckBox',
           'others'=>'Others',
           'sector'=>'Sector',
           'cond_radio'=>'Condition Radio',
       ];
       return $data;
    }

    public static function skills(){

        $data=[
            'communication'=>'Communication Skills',
            'punctuality'=>'Punctuality/Integrity',
            'team_work'=>'Team Work behaviors',
            'leadership'=>'Leadership Skills',
            'interpersonal'=>'Interpersonal Skills',
        ];
        return $data;
    }



    public static function workerSills()
    {
        return [
            'Communication Skills',
            'Punctuality/Integrity',
            'Team Work behaviors',
            'Leadership Skills',
            'Interpersonal Skills'
        ];
    }
}


               