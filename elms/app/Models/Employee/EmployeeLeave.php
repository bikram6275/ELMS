<?php

namespace App\Models\Employee;

use App\Models\Configuration\FiscalYear;
use App\Models\Leave\Leave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    use HasFactory;
    protected $table = "employee_leaves";
    protected $fillable = [
        'employee_id', 'year','paid_leave','paid_leave_used','leave_id'

    ];

    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }
    public function edyType()
    {
        return $this->belongsTo(EmployeeEducationType::class, 'education_type_id', 'id');

    }
    public function fiscal()
    {
        return $this->belongsTo(FiscalYear::class, 'year', 'id');
    }
    public function leaveType()
    {
        return $this->belongsTo(Leave::class, 'leavetype_id', 'id');
    }
}
