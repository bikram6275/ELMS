<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResources extends Model
{
    use HasFactory;
    protected $fillable=['enumerator_assign_id','resource_type','working_type','male_count','female_count','minority_count','nepali_count','foreigner_count','total','neighboring_count'];
}
