<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        // dd($this->data);
        foreach($this->data as $key1=>$value){
           foreach($value as $key=>$val)
           {
                if($key=='employer'){
                    $sheets[]=new HumanResourceExport($key,$val);
                }
                if($key == 'family_member'){
                    $sheets[]=new HumanResourceExport($key,$val);
                } 
                if($key == 'employees'){
                     $sheets[]=new HumanResourceExport($key,$val);
                }
            
           }


        }

        return $sheets;
    }
}
