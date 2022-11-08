<?php

namespace App\Models\Configuration;

use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['designation_name', 'designation_short_name'];
    protected static $logAttributes = ['designation_name', 'designation_short_name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
