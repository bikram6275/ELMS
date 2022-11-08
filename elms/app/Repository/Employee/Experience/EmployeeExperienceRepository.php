<?php


namespace App\Repository\Employee\Experience;
use App\Models\Employee\EmployeeExperience;
use Illuminate\Support\Facades\Auth;


class EmployeeExperienceRepository
{


    /**
     * @var EmployeeExperience
     */
    private $employeeExperience;

    public function __construct(EmployeeExperience $employeeExperience)
    {

        $this->employeeExperience = $employeeExperience;
    }

    public function all()
    {
        $result = $this->employeeExperience->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findByOrgs()
    {
        $result = $this->employeeExperience->orderBy('id', 'ASC')->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->employeeExperience->where('id',$id)->where('organization_id',Auth::user()->id)->first();
        return $result;
    }
    public function empExperience($id)
    {
        $result = $this->employeeExperience->where('employee_id',$id)->where('organization_id',Auth::user()->id)->get();
        return $result;
    }
}
