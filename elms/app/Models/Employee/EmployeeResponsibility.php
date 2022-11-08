<?php

namespace App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeResponsibility extends Model
{
    use HasFactory;
    protected $table = "employee_responsibilities";
    protected $fillable = [
        'employee_id', 'responsibility_type','level',
        'field', 'present_working_sector', 'name_of_supervisor',
        'name_of_ultimate_supervisor', 'organization_id'

    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }
    public function employeeResponsibilities()
    {
        return $this->belongsTo(Responsibility::class, 'responsibility_type', 'id');
    }

}
