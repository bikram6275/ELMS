<?php

namespace App\Models\Employee;

use App\Models\Configuration\FiscalYear;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePunishment extends Model
{
    use HasFactory;
    protected $table = "employee_punishments";
    protected $fillable = [
        'employee_id', 'defence_letter_received', 'de_promoted', 'grade_deducted','year','punishment_img','year',

    ];
    public function employee()
    {
        return $this->belongsTo(EmployeeRecord::class, 'employee_id', 'id');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
    public function fiscal()
    {
        return $this->belongsTo(FiscalYear::class, 'year', 'id');
    }
}
