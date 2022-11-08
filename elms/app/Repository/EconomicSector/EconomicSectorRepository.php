<?php

namespace App\Repository\EconomicSector;

use App\Models\EconomicSector\EconomicSector;
use App\Models\Logs\LoginLogs;


class EconomicSectorRepository
{

    /**
     * @var EconomicSector
     */
    private $economicsector;

    public function __construct(EconomicSector $economicSector)
    {
        $this->economicsector = $economicSector;
    }
    public function all($request=null)
    {

        $economicsectors = $this->economicsector->with('product');
        if ($request!=null && $request->has('parent_id') && $request->parent_id != null) {
            $economicsectors = $economicsectors->where('parent_id', '=', $request->parent_id);
        }

        $economicsectors =$economicsectors->orderBy('id', 'asc')->get();
        return $economicsectors;
    }
    public function parents()
    {
        $parents = $this->economicsector->orderBy('id', 'asc')->where('parent_id',0)->get();
        return $parents;
    }
    public function getAll()
    {
        $parents = $this->economicsector->orderBy('id', 'asc')->get();
        return $parents;
    }

    public function findById($id)
    {
        $economicsector = $this->economicsector->find($id);
        return $economicsector;
    }
    public function economicSectorFilter($id)
    {
        $economicsectors = $this->economicsector->where('parent_id',$id)->orderBy('id', 'asc')->get();
        return $economicsectors;
    }

    public function subSectorList()
    {
        $economicsectors = $this->economicsector->orderBy('id', 'asc')->get()->groupBy('parent_id');
        return $economicsectors;
    }

    public function allSubSectors()
    {
        $economicsectors = $this->economicsector->where('parent_id','<>',0)->orderBy('id', 'asc')->get();
        return $economicsectors;
    }

}
