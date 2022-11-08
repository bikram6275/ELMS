<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Employee\EmployeeEducationType;

class EmployeeEducation extends Model
{
    use HasFactory;
    protected $table = "employee_education";
    protected $fillable = [
        'employee_id', 'education_type_id', 'education_level_id'
    ];

    public function eduType()
    {
        return $this->hasMany(EmployeeEducationType::class, 'id', 'education_type_id');
    }
    public function eduLevel()
    {
        return $this->hasMany(EmployeeEducationLevel::class, 'id', 'education_level_id');
    }
}
