<?php

namespace App\Models;

use App\Models\EconomicSector\EconomicSector;
use App\Models\Occupation\Occupation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFuturePlan extends Model
{
    use HasFactory;

    protected $fillable=['enumerator_assign_id','occupation_id','sector_id','level','required_number','incorporate_possible','other_occupation_value'];

    public function sector()
    {
      return $this->belongsTo(EconomicSector::class,'sector_id');
    }

    public function occupation(){
        return $this->belongsTo(Occupation::class,'occupation_id');
    }
}

