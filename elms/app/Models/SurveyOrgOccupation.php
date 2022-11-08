<?php

namespace App\Models;

use App\Models\Configuration\Occupation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyOrgOccupation extends Model
{
    use HasFactory;

    protected $fillable=['survey_id','occupation_id'];
    // public function occupations()
    // {
    //     return $this->belongsTo(Occupation::class,'occupation_id','id');
    // protected $fillable=['survey_id','occupation_id'];

    public function survey()
    {
        return $this->belongsTo(Survey::class,'survey_id');
    }
    public function occupation()
    {
        return $this->belongsTo(Occupation::class,'occupation_id');
    }

    public function sectorWiseAssignedOccupation($id)
    {
        return Occupation::where('sector_id',$id)->get();
    }
}
