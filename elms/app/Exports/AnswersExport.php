<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnswersExport implements FromView,ShouldAutoSize, WithTitle
{
    private $answer;

    public function __construct($answer)
    {
        $this->answer=$answer;
    }

    public function view(): View
    {
   
        return view('emitter.exports.survey',['answer'=>$this->answer]);
        
    }

    public function title(): string
    {
        return 'Answers';
    }
}
