<?php

namespace App\Repository\Report;

use App\Models\Survey\Survey;
use App\Models\EnumeratorAssign\EnumeratorAssign;


class EnumeratorReportRepository
{

    /**
     * @var Survey
     */
    private $survey;

    public function __construct(Survey $survey, EnumeratorAssign $enumeratorAssign)
    {
        $this->survey = $survey;
        $this->enumeratorAssign = $enumeratorAssign;
    }
    public function all($request = null)
    {
        $surveys = $this->survey;
        
        $surveys = $surveys->orderBy('id', 'asc')->get();
        return $surveys;
    }


    public function findById($id)
    {
        $survey = $this->survey->find($id);
        return $survey;
    }

    public function enumeratorOrgReport($request)
    {
        $enumerators = $this->enumeratorAssign;
        if ($request->has('enumerator_id') && $request->enumerator_id != null) {
            $enumerators = $enumerators->where('emitter_id',$request->enumerator_id);
        }
        if ($request->has('survey_id') && $request->survey_id != null) {
            $enumerators = $enumerators->where('survey_id',$request->survey_id);
        }
        $enumerators = $enumerators->with('organization')->get();
        if($request->enumerator_id == null && $request->survey_id == null)
        {
            $enumerators = []; 
        }
        return $enumerators;
    }
}