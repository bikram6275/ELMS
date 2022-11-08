<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePreviousOrganization extends Model
{
    use HasFactory;
    protected $table = "employee_previous_orgs";
    protected $primaryKey = 'id';
    protected $fillable=['employee_id','organization_name','last_position','total_experience_year','total_experience_month'];
}
