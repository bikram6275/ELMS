<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Survey\Survey;
use App\Repository\Survey\SurveyRepository;

class Search extends Component
{
    public $search = '';
    private $surveyRepository;

    public function mount(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function render()
    {
        $status = $this->surveyRepository->surveyStatus($this->search);
        $model = Survey::where('survey_name','LIKE','%'.$this->search.'%')->get();
        return view('livewire.search',[
            'model' => $model
        ]);
    }
}
