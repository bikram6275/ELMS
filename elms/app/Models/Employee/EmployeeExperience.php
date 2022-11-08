<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends Model
{
    use HasFactory;
    protected $table = "employee_experiences";
    protected $fillable = [
        'employee_id', 'present_org_year','present_org_month','same_occu_year','same_occu_month','present_pos_year',
        'present_pos_month','other_org_year','other_org_month','total_exp_year','total_exp_month'

    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }
}
