<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuration\FiscalYear;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Models\Organization\Organization;

class Survey extends Model
{
    use HasFactory;
    protected $table = "surveys";
    protected $fillable = [
        'fy_id', 'survey_year', 'start_date', 'end_date', 'survey_name', 'detail', 'survey_status'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class, 'fy_id', 'id');
    }

    //    public function organizations()
    //    {
    //        return $this->belongsToMany(Organization::class, 'enumeratorassign_pivot', 'id','organization_id');
    //    }
    // public function enumertorAssignSurvey()
    // {
    //     return $this->belongsToMany(EnumeratorAssign::class,'enumeratorassign_pivot','survey_id','emitter_id','organization_id');
    // }
}
