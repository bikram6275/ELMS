<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class Question20Export implements FromView,ShouldAutoSize, WithTitle
{
    private $data;
  

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('emitter.exports.qsn20',['data'=>$this->data]);
    }

    public function title(): string
    {
        return 'Question 20';
        
    }
}
