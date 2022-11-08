<?php

namespace App\Models;

use App\Models\Education\EducationQualification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EconomicSector\EconomicSector;
use App\Models\Occupation\Occupation;


class TechnicalHumanResources extends Model
{
    use HasFactory;
    protected $fillable=['enumerator_assign_id','gender','emp_name','occupation_id','working_time','work_nature','training','edu_qua_general','edu_qua_tvet','work_exp1','ojt_apprentice','work_exp2','other_occupation_value'];

    public function tvetEducation(){
        return $this->belongsTo(EducationQualification::class,'edu_qua_tvet');
    }
    public function generalEducation(){
        return $this->belongsTo(EducationQualification::class,'edu_qua_general');
    }
    public function sector(){
        return $this->belongsTo(EconomicSector::class,'sector_id');
    }
    public function occupation(){
        return $this->belongsTo(Occupation::class,'occupation_id');
    }
}
