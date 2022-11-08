<?php

namespace App\Models\Configuration;

use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicSector extends Model
{
    use HasFactory;

    public function subsector($id)
    {
        return $this->where('parent_id',$id)->get();
    }

    public function product()
    {
        return $this->hasMany(ProductAndServices::class, 'sub_sector_id','id');
    }
    
}
