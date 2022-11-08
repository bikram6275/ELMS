<?php

namespace App\Http\Controllers\Emitter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class HomeController extends Controller
{
    private $enumeratorAssignRepository;

    public function __construct(EnumeratorAssignRepository $enumeratorAssignRepository){
        $this->enumeratorAssignRepository=$enumeratorAssignRepository;

    }


    public function index(){
        $surveys=$this->enumeratorAssignRepository->getSurveyList();
        return view('emitter.dashboard.dashboard',compact('surveys'));
    }

    public function show($id)
    {
        $assignSurvey = $this->enumeratorAssignRepository->surveyDetails($id);
        $assignedCount = $this->enumeratorAssignRepository->assignedCount(Auth::user()->id);
        $approvedCount = $this->enumeratorAssignRepository->approvedCount(Auth::user()->id);
        $feedbackCount = $this->enumeratorAssignRepository->feedbackCount(Auth::user()->id);
        return view('emitter.survey.organization',compact('assignSurvey','assignedCount','approvedCount','feedbackCount'));
    }
}
