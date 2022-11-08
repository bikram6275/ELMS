<?php

namespace App\Repository\Configurations;

use App\Models\Configuration\Gender;

class GenderRepository
{
    /**
     * @var Gender
     */
    private $gender;

    public function __construct(Gender $gender)
    {

        $this->gender = $gender;
    }
    public function all()
    {
        $result = $this->gender->orderBy('id', 'ASC')->get();
        return $result;
    }
    public function findById($id)
    {
        $result = $this->gender->find($id);
        return $result;
    }
}
