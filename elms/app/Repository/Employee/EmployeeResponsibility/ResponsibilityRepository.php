<?php

namespace App\Repository\Employee\EmployeeResponsibility;

use App\Models\Employee\Responsibility;
use Illuminate\Support\Facades\Auth;

class ResponsibilityRepository
{
    /**
     * @var Responsibility
     */
    private $responsibility;

    public function __construct(Responsibility $responsibility){

        $this->responsibility = $responsibility;
    }
    public function all()
    {
        $result = $this->responsibility->orderBy('id', 'ASC')->get();
        return $result;
    }

}
