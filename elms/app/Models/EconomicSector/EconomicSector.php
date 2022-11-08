<?php

namespace App\Models\EconomicSector;

use App\Models\BusinessFuturePlan;
use App\Models\Configuration\ProductAndServices;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EconomicSector extends Model
{
    use HasFactory;
    protected $table = "economic_sectors";
    protected $parentColumn = 'parent_id';
    protected $fillable=[
        'parent_id','sector_name'
    ];

    public function getChildCategories(){
        return $this->hasMany(self::class, 'parent_id','id');
    }
    public function getParentCategory() {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class,'sector_id','id');
    }

    public function product()
    {
        return $this->hasMany(ProductAndServices::class, 'sub_sector_id','id');
    }
    public function businessPlan()
    {
        return $this->hasMany(BusinessFuturePlan::class, 'sector_id','id');
    }

}
