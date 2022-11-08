<?php

namespace App\Repository\Leave;

use App\Models\Leave\Leave;

class LeaveRepository
{
    /**
     * @var Leave
     */
    private $leave;

    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }
    public function all()
    {
        $result = $this->leave->orderBy('leave_type', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->leave->find($id);
        return $result;
    }


}
