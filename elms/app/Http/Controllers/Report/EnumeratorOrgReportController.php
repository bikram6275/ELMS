<?php

namespace App\Http\Controllers\Report;

use App\Exports\EnumeratorOrganization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repository\Survey\SurveyRepository;
use App\Repository\Emitter\EmitterRepository;
use App\Repository\Report\EnumeratorReportRepository;

class EnumeratorOrgReportController extends Controller
{

    protected $emitterRepository;

    public function __construct(EnumeratorReportRepository $enumeratorReportRepository, EmitterRepository $emitterRepository, SurveyRepository $surveyRepository)
    {
        $this->enumeratorReportRepository = $enumeratorReportRepository;
        $this->emitterRepository = $emitterRepository;
        $this->surveyRepository = $surveyRepository;

    }


    public function index(Request $request)
    {   
        $data = $this->enumeratorReportRepository->enumeratorOrgReport($request);
        $enumerators = $this->emitterRepository->all();
        $surveys = $this->surveyRepository->all();

        return view('backend.report.enumeratororgreport',compact('data','enumerators','surveys'));
    }

    public function export(Request $request)
    {
        $data = $this->enumeratorReportRepository->enumeratorOrgReport($request);
        return Excel::download(new EnumeratorOrganization($data), 'orgs.xlsx');

    }
}
