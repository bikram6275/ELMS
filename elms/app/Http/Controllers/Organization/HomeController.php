<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Repository\Employee\EmployeeRecord\EmployeeRecordRepository;
use App\Repository\Employee\EmployeeType\EmployeeTypeRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $employeeRecordRepository;
    private $employeeTypeRepository;

    public function __construct(EmployeeRecordRepository $employeeRecordRepository, EmployeeTypeRepository $employeeTypeRepository){
        $this->employeeRecordRepository=$employeeRecordRepository;
        $this->employeeTypeRepository=$employeeTypeRepository;
    }

    public function index(){
        $emp_record=$this->employeeRecordRepository->empTypeReport();
        $emp_type=$this->employeeTypeRepository->employeeType()->pluck('name','id');
        return view('organization.dashboard.dashboard',compact('emp_type','emp_record'));
    }

}
