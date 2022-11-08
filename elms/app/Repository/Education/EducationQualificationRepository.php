<?php


namespace App\Repository\Education;

use App\Models\Education\EducationQualification;

class EducationQualificationRepository
{
    /**
     * @var EducationQualification
     */
    private $educationqualification; 

    public function __construct(EducationQualification $educationqualification)

    {
        $this->educationqualification = $educationqualification;
    }

    public function all()
    {
        $qualifications = $this->educationqualification->orderBy('id', 'asc')->get();
        return $qualifications;
    }

    public function findById($id)
    {
        $qualification = $this->educationqualification->find($id);
        return $qualification;
    }

    public function educations(){
        $data=$this->educationqualification->get()->groupBy('type');
        return $data;
    }

}