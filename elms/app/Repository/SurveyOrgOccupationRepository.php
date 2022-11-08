<?php

namespace App\Repository;

use App\Models\Answers;
use App\Models\SurveyOrgOccupation;

class SurveyOrgOccupationRepository
{

    /**
     * @var Answers
     */
    private $org_occu;

    public function __construct(SurveyOrgOccupation $org_occu)
    {
        $this->org_occu = $org_occu;
    }

    public function orgOccupation($survey_id,$sector_id)
    {
        $data=$this->org_occu
        ->leftjoin('occupations','occupations.id','=','survey_org_occupations.occupation_id')
        ->join('economic_sectors','economic_sectors.id','=','occupations.sector_id')
        ->where('survey_id',$survey_id)
        ->where('economic_sectors.id',$sector_id)
        ->get();
        return $data;
    }
    public function all()
    {
        $data = $this->org_occu->orderBy('id', 'asc')->get();
        return $data;
    }

    public function findById($id)
    {
        $data = $this->org_occu->find($id);
        return $data;
    }

    public function findBySurvey($survey_id)
    {
        $data=$this->org_occu->where('survey_id',$survey_id)->get();
        return $data;
    }





}
