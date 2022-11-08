<?php

namespace App\Models;

use App\Models\Occupation\Occupation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherOccupationDetails extends Model
{
    use HasFactory;
    protected $fillable=['enumerator_assign_id','occupation_id','present_demand','demand_two_year','demand_five_year','other_value'];

    public function occupation()
    {
        return $this->belongsTo(Occupation::class,'occupation_id');
    }
}
