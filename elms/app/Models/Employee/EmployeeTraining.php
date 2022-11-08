<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
    use HasFactory;
    protected $table = "employee_trainings";
    protected $fillable = [
        'employee_id', 'organization_id', 'training_type', 'pre_service_yr','pre_service_month','in_service_yr','in_service_month','others'

    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }


}
