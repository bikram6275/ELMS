<?php

namespace App\Http\Controllers;

use App\Models\Answers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\Survey\SurveyRepository;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $surveyRepository;
    private $enumeratorAssignRepository;

    public function __construct(
        SurveyRepository $surveyRepository,
        EnumeratorAssignRepository $enumeratorAssignRepository
    ) {
        $this->middleware('auth')->except('privacyPolicy');

        $this->surveyRepository = $surveyRepository;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {


        $survey = EnumeratorAssign::where('status', 'supervised')->get();
        $surveyList = $this->surveyRepository->activeSurvey();
        $completeList = $this->enumeratorAssignRepository->completeSurvey($request);
        $surveyStatus = $this->enumeratorAssignRepository->surveyStatus();
        $status = $this->surveyRepository->surveyStatus($request);
        return view('backend.dashboard', compact('surveyList', 'completeList', 'surveyStatus', 'status'));
    }

    public function completeOrganization()
    {
        $completeList = $this->enumeratorAssignRepository->allCompleteSurvey();
        return view('complete_survey.index', compact('completeList'));
    }

    public function privacyPolicy()
    {
        return view('backend.privacy_policy');
    }

    public function duplicateAnswer()
    {
        $duplicated = DB::table('answers')
            ->select('enumerator_assign_id', 'qsn_id', DB::raw('count(`enumerator_assign_id`) as occurences'))
            ->groupBy('enumerator_assign_id', 'qsn_id')
            ->having('occurences', '>', 1)
            ->where('deleted','0')
            ->get();
            $a = [];
            foreach ($duplicated as $d) {
                $a[] = Answers::where('enumerator_assign_id', $d->enumerator_assign_id)->where('qsn_id', $d->qsn_id)->where('deleted','0')->get()->last();
                
            }
        foreach ($duplicated as $d) {
            $answer = Answers::where('enumerator_assign_id', $d->enumerator_assign_id)->where('qsn_id', $d->qsn_id)->where('deleted','0')->get()->last();
            $answer->update([
                'Deleted' => '1'
            ]);
        }
        return view('backend.duplicate',compact('a'));
    }
}
