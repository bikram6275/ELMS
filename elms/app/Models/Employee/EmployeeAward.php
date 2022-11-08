<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Employee\EmployeeRecord;
use  App\Models\Configuration\FiscalYear;


class EmployeeAward extends Model
{
    use HasFactory;
    protected $table = "employee_award";
    protected $fillable = ['org_id',
        'employee_id', 'grade_earned', 'promotion_received','appreciation_letter','employee_of_yr','fy_id'

    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }
    public function fiscal()
    {
        return $this->belongsTo(FiscalYear::class, 'fy_id', 'id');
    }

}
