<?php

namespace App\Models\Configuration;

use App\Models\Configuration\Office;
use App\Models\Configuration\Pradesh;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Configuration\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['pradesh_id', 'district_code', 'nepali_name', 'english_name'];
    protected $table = 'districts';
    protected static $logAttributes = ['district_code', 'nepali_name'];

    public function pradesh()
    {
        return $this->belongsTo(Pradesh::class, 'pradesh_id', 'id');
    }

    public function municipality()
    {
        return $this->hasMany(Municipality::class);
    }

    public function office()
    {
        return $this->hasMany(Office::class);
    }
}
