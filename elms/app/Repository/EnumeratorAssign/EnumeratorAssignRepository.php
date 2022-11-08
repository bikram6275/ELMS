<?php


namespace App\Repository\EnumeratorAssign;

use App\Models\CoordinatorSupervisor;
use App\Models\Emitter;
use Illuminate\Support\Facades\Auth;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Models\User;

class EnumeratorAssignRepository
{
    /**
     * @var EnumeratorAssign
     */
    private $enumeratorAssign;

    public function __construct(EnumeratorAssign $enumeratorAssign, Emitter $emitter)
    {
        $this->enumeratorAssign = $enumeratorAssign;
        $this->emitter = $emitter;
    }

    public function all($request)
    {
        $enumeratorAssigns = $this->enumeratorAssign;
        if ($request != null && $request->has('survey_id') && $request->survey_id != null) {

            $emitter_ids = $enumeratorAssigns->where('survey_id', '=', $request->survey_id)->where('organization_id','<>','NULL')->where('emitter_id','<>','NULL')->select('emitter_id')->groupBy('emitter_id')->get();
            $emitter = array();
            foreach ($emitter_ids as $key => $emitter_id) {
                $emitter[] = $emitter_id->emitter;
            }
        } else {
            $emitter = Emitter::all();
        }
        return $emitter;
    }
    public function findById($id)
    {
        $enumeratorAssign = $this->enumeratorAssign->with('survey')->find($id);
        return $enumeratorAssign;
    }

    public function getSurveyList()
    {
        // $result = $this->enumeratorAssign->select('survey_id')->with('survey')->groupBy('survey_id')->where('emitter_id', auth()->user()->id)->get();
        $result = $this->enumeratorAssign->select('survey_id')->with('survey', function ($q) {
            $q->whereDate('start_date', '<=', date("Y-m-d"))->whereDate('end_date', '>=', date("Y-m-d"))->where('survey_status', 'active');
        })->groupBy('survey_id')->where('emitter_id', auth()->user()->id)->get();
        return $result;
    }
    public function getAllSurveyList()
    {
        $result = $this->enumeratorAssign->select('survey_id')->with('survey', function ($q) {
            $q->whereDate('start_date', '<=', date("Y-m-d"))->whereDate('end_date', '>=', date("Y-m-d"))->where('survey_status', 'active');
        })->groupBy('survey_id')->get();
        return $result;
    }

   


    public function orgsFilter($survey_id)
    {
        $result = $this->enumeratorAssign->where('survey_id', $survey_id)->where('status','supervised')->with('organization')->get();
        return $result;
    }
    public function surveyDetails($id)
    {
        $user = Auth::user();
        $data = $this->enumeratorAssign
            ->leftjoin('organizations', 'enumeratorassign_pivot.organization_id', 'organizations.id')
            ->where('survey_id', $id)->where('emitter_id', $user->id)
            ->with('survey')
            ->select('enumeratorassign_pivot.*', 'enumeratorassign_pivot.id as pivot_id', 'organizations.*')
            ->get();
        return $data;
    }



    public function filter($enumerator_id, $survey_id)
    {
        $result = $this->enumeratorAssign->where('emitter_id', $enumerator_id)->where('survey_id', $survey_id)->get();
        return $result;
    }

    public function completeSurvey($request)
    {
        $result = $this->enumeratorAssign->where('start_date', '<>', null)->where('finish_date', '<>', null)->where('status', 'supervised');
        if ($request->has('district_id') && $request->district_id != null) {
            $result = $result->whereHas('organization', function ($query) use ($request) {
                $query = $query->where('district_id', $request->district_id);
            });
        }
        if ($request->has('pradesh_id') && $request->pradesh_id != null) {
            $result = $result->whereHas('organization', function ($query) use ($request) {
                $query = $query->where('pradesh_id', $request->pradesh_id);
            });
        }
        $result = $result->paginate(10);
        return $result;
    }
    public function allCompleteSurvey()
    {
        $result = $this->enumeratorAssign->where('start_date', '<>', null)->where('finish_date', '<>', null)->get();
        return $result;
    }

    public function surveyStatus()
    {
        $query = $this->enumeratorAssign->join('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
            ->where('surveys.survey_status', 'active');
        $query1 = clone $query;
        $query2 = clone $query;
        $result['total'] = $query->count();
        $result['inprogress'] = $query1->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', null)->count();
        $result['complete'] = $query2->where('enumeratorassign_pivot.start_date', '<>', null)->where('enumeratorassign_pivot.finish_date', '<>', null)->count();
        return $result;
    }

    public function allSurveyDetails($id)
    {
        $data = $this->enumeratorAssign
            ->leftjoin('organizations', 'enumeratorassign_pivot.organization_id', 'organizations.id')
            ->where('survey_id', $id)
            ->with('survey')
            ->select('enumeratorassign_pivot.*', 'enumeratorassign_pivot.id as pivot_id', 'organizations.*')
            ->get();
        return $data;
    }

    public function getSupervisorOrganizations($request)
    {
        $response = $this->enumeratorAssign;
        if ($request != null && $request->has('enumerator_id') && $request->enumerator_id != null) {
            $response = $response->where('emitter_id', $request->enumerator_id);
        }
        $response = $response->whereIn('status', ['unsupervised', 'feedback'])->with('organization', 'emitter')->whereHas('emitter', function ($query) {
            $query->where('supervisor_id', auth()->user()->id);
        })->get();

        return $response;
    }

    public function getApprovedOrganizations($request)
    {
        $data = $this->enumeratorAssign->where('status', 'supervised')->with('organization');
        return $this->apiOrgFilter($data,$request);

    }


    public function getCoordinatorOrganizations($request)
    {
        $response = $this->enumeratorAssign;
        $supervisors = CoordinatorSupervisor::where('coordinator_id', auth()->user()->id)->pluck('supervisor_id');
        if ($request != null && $request->has('supervisor_id') && $request->supervisor_id != null) {
            $r = $response->whereIn('status', ['field_supervised', 'feedback', 'supervised'])->with('organization', 'emitter')
                ->whereHas('emitter', function ($query) use ($request) {
                    $query = $query->where('supervisor_id', $request->supervisor_id);
                });
        } else {
            $r = $response->whereIn('status', ['field_supervised', 'feedback', 'supervised'])->with('organization', 'emitter')
                ->whereHas('emitter', function ($query) use ($supervisors) {
                    $query = $query->whereIn('supervisor_id', $supervisors);
                });
        }
        $r = $r->get();
        return $r;
    }

    public function coordinatorSupervisor()
    {
        $result = User::whereHas('supervisor', function ($query) {
            $query = $query->where('coordinator_id', auth()->user()->id);
        })->get();
        return $result;
    }

    public function completedSurvey($request){
        $query = $this->enumeratorAssign;
        $result = $query->where('emitter_id',$request)->where('emitter_id','<>',null)->where('status','supervised')->with('organization')->get();
        $result->assigned_organizations = $query->where('emitter_id', $request)->count();
        $result->completed_organizations = $query->where('emitter_id',$request)->where('status','supervised')->count();
        return $result;
    }

    public function assignedCount($request)
    {
        $data = $this->enumeratorAssign->where('emitter_id',$request)->where('organization_id','<>','NULL')->count();
        return $data;
    } 

    public function approvedCount($request)
    {
        $data = $this->enumeratorAssign->where('emitter_id',$request)->where('status','supervised')->count();
        return $data;
    }

    public function feedbackCount($request)
    {
        $data = $this->enumeratorAssign->where('emitter_id',$request)->where('status','feedback')->count();
        return $data;
    }

    public function supervisorAssignedCount()
    {
        $data = $this->enumeratorAssign->where('organization_id','<>','NULL')->whereHas('emitter.supervisor',function($query){
            $query = $query->where('id',Auth::user()->id);
        })->count();
        return $data;
    }

    public function supervisorApprovedCount()
    {
        $data = $this->enumeratorAssign->where('status','supervised')->whereHas('emitter.supervisor',function($query){
            $query = $query->where('id',Auth::user()->id);
        })->count();
        return $data;
    }

    public function supervisorFeedbackCount()
    {
        $data = $this->enumeratorAssign->where('status','feedback')->whereHas('emitter.supervisor',function($query){
            $query = $query->where('id',Auth::user()->id);
        })->count();
        return $data;
    }
    public function assignedOrganizaions($request)
    {
        $organizations = $this->enumeratorAssign->where('emitter_id', $request->enumerator_id)->where('survey_id', $request->survey_id)->with('organization.district', 'organization.sector');
           
        return $this->apiOrgFilter($organizations,$request);
    }

    public function apiOrgFilter($model, $data)
    {
        if(isset($data['pradesh_id'])&& $data['pradesh_id'] != null){
            
            $model = $model->whereHas('organization',function($query) use($data){
                $query = $query->where('pradesh_id',$data->pradesh_id);
            });
           
        }
        if(isset($data['district_id']) && $data['district_id'] != null){
            $model = $model->whereHas('organization',function($query) use($data){
                $query = $query->where('district_id',$data->district_id);
            });
        }
        if(isset($data['sector_id']) && $data['sector_id'] != null){
            $model = $model->whereHas('organization',function($query) use($data){
                $query = $query->where('sector_id',$data->sector_id);
            });
        }
        return $model->orderBy('id', 'asc')->get();
    }


}
