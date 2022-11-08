<?php


namespace App\Repository\Employee\LeaveType;
use App\Models\LeaveType\LeaceType;


class EmployeeLeaveTypeRepository
{
    /**
     * @var LeaceType
     */
    private $leaveType;

    public function __construct(LeaceType $leaveType)
    {


        $this->leaveType = $leaveType;
    }
    public function all()
    {
        $result = $this->leaveType->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->leaveType->find($id);
        return $result;
    }

}
