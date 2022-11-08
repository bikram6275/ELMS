<?php

namespace App\Models\Employee;

use App\Models\Configuration\District;
use App\Models\Configuration\Gender;
use App\Models\Configuration\Municipality;
use App\Models\Configuration\Pradesh;
use App\Models\Employee\EmployeeTraining;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EmployeeRecord extends Model
{
    use HasFactory;
    protected $table = "employees";
    protected $fillable = [
        'employee_name', 'date_of_birth','gender', 'father_name', 'mother_name', 'grand_father_name', 'spouse_name', 'no_of_children',
        'marital_status','permanent_pradesh_id','permanent_district_id','permanent_muni_id','permanent_ward_no',
        'pradesh_id','district_id','muni_id','ward_no','phone_no','mobile_no','email','first_entry_position','level',
        'promoted_level','present_position','immediate_promoted_date','working_hour_per_week','working_hour_per_days_in_month',
        'organization_id','join_date','employee_type_id'
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }
    public function pradesh()
    {
        return $this->belongsTo(Pradesh::class, 'pradesh_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'muni_id', 'id');
    }
    public function pradeshPer()
    {
        return $this->belongsTo(Pradesh::class, 'permanent_pradesh_id', 'id');
    }

    public function districtPer()
    {
        return $this->belongsTo(District::class, 'permanent_district_id', 'id');
    }

    public function municipalityPer()
    {
        return $this->belongsTo(Municipality::class, 'permanent_muni_id', 'id');
    }
    public function edu()
    {
        return $this->belongsTo(EmployeeEducation::class, 'id', 'employee_id');
    }
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'gender', 'id');
    }
    public function training()
    {
        return $this->belongsTo(EmployeeTraining::class, 'id', 'employee_id');
    }
}
