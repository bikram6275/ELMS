<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiscalYear extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'fy_start_date', 'fy_start_date_localized', 'fy_end_date',
        'fy_end_date_localized', 'fy_status', 'fy_name'
    ];
    protected static $logAttributes = ['fy_name', 'fy_start_date', 'fy_end_date'];
}
