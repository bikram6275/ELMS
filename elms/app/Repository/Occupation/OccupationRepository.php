<?php

namespace App\Repository\Occupation;

use App\Models\Occupation\Occupation;
use App\Models\Logs\LoginLogs;
use http\Env\Request;


class OccupationRepository
{

    /**
     * @var Occupation
     */
    private $occupation;

    public function __construct(Occupation $occupation)
    {
        $this->occupation = $occupation;
    }
    public function all($request=null)
    {
        $occupations = $this->occupation;
        if ($request!=null && $request->has('parent_id') && $request->parent_id != null) {
            $occupations = $occupations->where('sector_id', '=', $request->parent_id);
        }

        $occupations =$occupations->orderBy('id', 'asc')->get();
        return $occupations;
    }


    public function findById($id)
    {
        $occupation = $this->occupation->find($id);
        return $occupation;
    }

    public function getOccupation()
    {
        $occupations =$this->occupation->orderBy('id', 'asc')->get()->groupBy('sector_id');
        return $occupations;
    }

    public function sectorWiseOccupation($sector_id)
    {
        $occupations =$this->occupation->get();
        return $occupations;
    }

    public function sectoroccup($sector_id)
    {
        $occupations =$this->occupation->where('sector_id',$sector_id)->orWhere('sector_id',null)->get();
        return $occupations;
    }

}
