<?php

namespace App\Http\Controllers;

use App\Models\EnumeratorAssign\EnumeratorAssign;
use Illuminate\Http\Request;

class MapController extends Controller
{
    protected $model;

    public function __construct(EnumeratorAssign $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $model = $this->model->where('status','supervised')->where('latitude','<>','NULL')->with('organization');
        if(isset($request['pradesh_id']) && $request['pradesh_id'] != null)
        {
            $model = $model->whereHas('organization',function($query) use($request){
                $query->where('pradesh_id',$request->pradesh_id);
            });
        }
        if(isset($request['district_id']) && $request['district_id'] != null)
        {
            $model = $model->whereHas('organization',function($query) use($request){
                $query->where('district_id',$request->district_id);
            });
        }
        $model = $model->get();
        return view('backend.map.index',[
            'model' => $model
        ]);
    }
}
