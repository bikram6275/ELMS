<?php

namespace App\Models;

use App\Models\EnumeratorAssign\EnumeratorAssign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyEmpStatus extends Model
{
    use HasFactory;

    public function pivot()
    {
        return $this->belongsTo(EnumeratorAssign::class,'enumerator_assign_id','id');
    }
    protected $fillable=['enumerator_assign_id','occupation_id','working_number','required_number','for_two_years','for_five_years'];
}
