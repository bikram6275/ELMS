<?php

namespace App\Models\Configuration;

use App\Models\Configuration\District;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pradesh extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['pradesh_name'];
    protected $table = 'pradeshes';
    protected $dates = ['deleted_at'];

    protected static $logAttributes = ['pradesh_name'];



    public function district()
    {
        return $this->hasMany(District::class);
    }
}
