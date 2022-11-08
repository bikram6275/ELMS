<?php

namespace App\Models\EnumeratorAssign;

use App\Models\Answers;
use App\Models\Organization\Organization;
use App\Models\Emitter;
use App\Models\Survey\Survey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnumeratorAssign extends Model
{
    use HasFactory;

    protected $table = "enumeratorassign_pivot";
    protected $fillable = [
        'emitter_id', 'organization_id', 'survey_id', 'start_date', 'finish_date', 'latitude', 'longitude', 'supervisor_name', 'supervising_date', 'respondent_name', 'designation', 'interview_date', 'status', 'remarks'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function emitter()
    {
        return $this->belongsTo(Emitter::class, 'emitter_id', 'id');
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }

    public function assigned($id)
    {
        $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', null)->count();
        return $a;
    }
    public function inProgress($id)
    {
        $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', '<>', null)->where('finish_date', null)->count();
        return $a;
    }
    public function complete($id)
    {
        $a =  EnumeratorAssign::where('emitter_id', $id)->where('start_date', '<>', null)->where('finish_date', '<>', null)->count();
        return $a;
    }

    public function answer()
    {
        return $this->hasMany(Answers::class,'enumerator_assign_id','id');
    }
}
