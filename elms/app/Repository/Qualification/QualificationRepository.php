<?php


namespace App\Repository\Qualification;
use App\Models\Qualification\Qualification;

class QualificationRepository
{
    /**
     * @var Qualification
     */
    private $qualification;

    public function __construct(Qualification $qualification)
    {

        $this->qualification = $qualification;
    }

    public function all()
    {

        $qualifications =$this->qualification->orderBy('id', 'asc')->get();
        return $qualifications;
    }
    public function findById($id)
    {
        $qualification = $this->qualification->find($id);
        return $qualification;
    }
}
