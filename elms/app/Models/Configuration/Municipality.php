<?php

namespace App\Models\Configuration;

use App\Models\Configuration\District;
use App\Models\Configuration\MuniType;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['muni_type_id', 'district_id', 'muni_code', 'muni_name', 'muni_name_en'];
    protected $table = 'municipalities';

    protected static $logAttributes = ['muni_code', 'muni_name'];


    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function muniType()
    {
        return $this->belongsTo(MuniType::class, 'muni_type_id', 'id');
    }
}
