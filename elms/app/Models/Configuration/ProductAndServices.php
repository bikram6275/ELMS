<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAndServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_sector_id',
        'product_and_services_name'
    ];

    public function subSector()
    {
        return $this->belongsTo(EconomicSector::class,'sub_sector_id','id');
    }

}
