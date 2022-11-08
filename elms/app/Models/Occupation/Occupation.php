<?php

namespace App\Models\Occupation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\EconomicSector\EconomicSector;
use App\Models\SurveyOrgOccupation;

class Occupation extends Model
{
    use HasFactory;
    protected $table = "occupations";
    protected $fillable=[
        'sector_id','occupation_name'
    ];

    public function economicsector()
    {
        return $this->belongsTo(EconomicSector::class, 'sector_id', 'id');
    }

    public function surveyOccupation()
    {
        return $this->hasMany(SurveyOrgOccupation::class,'occupation_id','id');
    }
}
