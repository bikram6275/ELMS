<?php


namespace App\Repository\Survey;

use App\Models\Survey\Survey;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SurveyRepository
{
    /**
     * @var Survey
     */
    private $survey;
    /**
     * @var EnumeratorAssign
     */
    private $enumeratorAssign;

    public function __construct(Survey $survey, EnumeratorAssign $enumeratorAssign)
    {
        $this->survey = $survey;
        $this->enumeratorAssign = $enumeratorAssign;
    }

    public function all($request = null)
    {
        $surveys = $this->survey;
        $enumeratorAssigns = $this->enumeratorAssign;
        if ($request != null && $request->has('enumerator_id') && $request->enumerator_id != null) {
            $surveys = $enumeratorAssigns->where('emitter_id', '=', $request->enumerator_id);
        }

        $surveys = $surveys->orderBy('id', 'desc')->get();
        return $surveys;
    }


    public function activeSurvey()
    {
        $surveys = $this->survey->where('survey_status', 'active')->orderBy('id', 'asc')->get();
        return $surveys;
    }

    public function findById($id)
    {
        $survey = $this->survey->find($id);
        return $survey;
    }

    public function assignedSurvey($request)
    {
        #Get active survey for enumerator which are assigned to them
        $assigned_survey = EnumeratorAssign::where('emitter_id', $request->enumerator_id)->whereHas('survey', function ($q) {
            $q->whereDate('start_date', '<=', date("Y-m-d"))->whereDate('end_date', '>=', date("Y-m-d"))->where('survey_status', 'active');
        })->select('survey_id')->distinct()->get();
        return $assigned_survey;
    }
    public function getSurvey()
    {

        $survey = $this->survey->get();
        return $survey;
    }


    public function surveyStatusQuery($request)
    {
        $query = $this->enumeratorAssign->join('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
            ->where('surveys.survey_status', 'active');
           
        if($request->has('district_id') && $request->district_id != null)
        {
            $query->whereHas('organization',function($query) use($request){
                $query = $query->where('district_id',$request->district_id);
            });
        }
        if($request->has('pradesh_id') && $request->pradesh_id != null)
        {
            $query->whereHas('organization',function($query) use($request){
                $query = $query->where('pradesh_id',$request->pradesh_id);
            });
        }
        if($request->has('survey_id') && $request->survey_id != null)
        {
            $query->whereHas('organization',function($query) use($request){
                $query = $query->where('survey_id',$request->survey_id);
            });
        }
        return $query;
    }

    public function surveyStatus($request)
    {  
        $result['overall']['total'] = $this->surveyStatusQuery($request)->count();
        $result['overall']['inprogress'] =  $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->whereIn('enumeratorassign_pivot.status', ['unsupervised','field_supervised','feedback'])->count();
        $result['overall']['complete'] =  $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '<>', null)->where('enumeratorassign_pivot.status','supervised')->count();
        $result['overall']['incomplete'] =  $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', null)->count();
        $result['overall']['enumerator'] = $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '=', null)->where('enumeratorassign_pivot.status','unsupervised')->count();
        $result['overall']['supervisor'] = $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '<>', null)->where('enumeratorassign_pivot.status','unsupervised')->count();
        $result['overall']['coordinator'] = $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '<>', null)->where('enumeratorassign_pivot.status','field_supervised')->count();
        $result['overall']['feedback'] = $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '<>', null)->where('enumeratorassign_pivot.status','feedback')->count();

       
       
        $surveyStatusQuery=$this->surveyStatusQuery($request)->where('enumeratorassign_pivot.finish_date', '=', Date::now()->format('Y-m-d'));
        $result['today']['total'] = $surveyStatusQuery->count();
        $result['today']['inprogress'] =  $this->surveyStatusQuery($request)->where('enumeratorassign_pivot.start_date', '=', Date::now()->format('Y-m-d'))->whereIn('enumeratorassign_pivot.status', ['unsupervised','field_supervised'])->count();
        $result['today']['complete'] =  $surveyStatusQuery->where('enumeratorassign_pivot.status','supervised')->count();
        $result['today']['incomplete'] =  $surveyStatusQuery->where('enumeratorassign_pivot.start_date', null)->where('enumeratorassign_pivot.finish_date', null)->count();
        
        $result['weekly'] ['total'] = $this->surveyStatusQuery($request)->whereBetween('enumeratorassign_pivot.finish_date', [Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()])->count();
        $result['monthly'] ['total'] = $this->surveyStatusQuery($request)->whereMonth('enumeratorassign_pivot.finish_date',Carbon::now()->month)->count();
        $result['yearly'] ['total'] =  $this->surveyStatusQuery($request)->whereBetween('enumeratorassign_pivot.finish_date', [Carbon::now()->startOfYear()->toDateString(), Carbon::now()->endOfYear()->toDateString()])->count();
        return $result;
    }

   
}
