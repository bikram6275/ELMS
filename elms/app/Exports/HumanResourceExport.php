<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class HumanResourceExport implements FromView,ShouldAutoSize, WithTitle
{
    private $data;
  

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('emitter.exports.human_resource',['human_resource'=>$this->data]);
    }

    public function title(): string
    {
        return 'HumanResource';
        
    }
}