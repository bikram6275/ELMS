<?php

namespace App\Repository\Report;

use App\Models\Survey\Survey;
use App\Models\EnumeratorAssign\EnumeratorAssign;


class OrganizationReportRepository
{

    /**
     * @var Survey
     */

    private $model;

    public function __construct(EnumeratorAssign $model)
    {
        $this->model = $model;
    }
    
    public function approvedOrganizations($request)
    {
        $approved_organizations = $this->model->where('status','supervised');
        if($request->has('survey_id') && $request->survey_id != null)
        {
            $approved_organizations = $approved_organizations->where('survey_id',$request->survey_id);
            
        }
        if($request->has('paradesh_id') && $request->pradesh_id != null)
        {
            $approved_organizations = $approved_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('pradesh_id',$request->pradesh_id);
            });
        }
        if($request->has('district_id') && $request->district_id != null)
        {
            $approved_organizations = $approved_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('district_id',$request->district_id);
            });
        }
        if($request->has('sector_id') && $request->sector_id != null)
        {
            $approved_organizations = $approved_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('sector_id',$request->sector_id);
            });
        }
        $approved_organizations = $approved_organizations->with('organization')->get();
        return $approved_organizations;
    }

    public function assignedOrganizations($request)
    {
        $assigned_organizations = $this->model->where('status','<>','supervised');
        if($request->has('survey_id') && $request->survey_id != null)
        {
            $approved_organizations = $assigned_organizations->where('survey_id',$request->survey_id);
            
        }
        if($request->has('pradesh_id') && $request->pradesh_id != null)
        {
            $assigned_organizations = $assigned_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('pradesh_id',$request->pradesh_id);
            });
        }
        if($request->has('district_id') && $request->district_id != null)
        {
            $assigned_organizations = $assigned_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('district_id',$request->district_id);
            });
        }
        if($request->has('sector_id') && $request->sector_id != null)
        {
            $assigned_organizations = $assigned_organizations->whereHas('organization',function($query) use($request){
                $query = $query->where('sector_id',$request->sector_id);
            });
        }
        $assigned_organizations = $assigned_organizations->with('organization')->get();

        return $assigned_organizations;

    }
}