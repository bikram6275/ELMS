<?php

namespace App\Models;

use App\Models\EconomicSector\EconomicSector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnologyDetails extends Model
{
    use HasFactory;
    protected $fillable=['enumerator_assign_id','sector_id','technology'];

    public function sector()
    {
      return $this->belongsTo(EconomicSector::class,'sector_id');
    }
}
