<?php

namespace App\Repository;

use App\Models\CoordinatorSupervisor;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Models\User;

class CoordinatorSupervisorRepository
{

    /**
     * @var CoordinatorSupervisor
     */
    private $model;

    protected $user;

    public function __construct(CoordinatorSupervisor $model, User $user)
    {
        $this->model = $model;
        $this->user = $user;
    }

    public function all()
    {
        $model = $this->model->with('coordinator','supervisor')->get();
        return $model;
    }


    public function findById($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function coordinators()
    {
        $model = $this->user->whereHas('user_group',function($query){
            $query= $query->where('group_name','Coordinator');
        })->with('coordinators')->get();

        return $model;
    }

    public function supervisors()
    {
        $model = $this->user->whereHas('user_group',function($query){
            $query= $query->where('group_name','Supervisor');
        })->with('supervisor')->get();

        return $model;
    }
    public function coordinatorsurvey($request)
    {
        $model = EnumeratorAssign::where('status','field_supervised')->with('emitter.supervisor.supervisor.coordinator');
        if($request->has('pradesh_id') && $request->pradesh_id != null){
            $model = $model->whereHas('organization',function($query) use ($request){
                $query = $query->where('pradesh_id',$request->pradesh_id);
            });
        }
        if($request->has('district_id') && $request->district_id != null){
            $model = $model->whereHas('organization',function($query) use ($request){
                $query = $query->where('district_id',$request->district_id);
            });
        }
        $model = $model->get()->groupBy('emitter.supervisor.supervisor.coordinator.name');
        return $model;
    }

   

    
}