<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Configuration\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MuniType extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['muni_type_name'];
    protected $table = 'muni_types';

    protected static $logAttributes = ['muni_type_name'];

    public function municipality()
    {
        return $this->hasMany(Municipality::class);
    }
}
