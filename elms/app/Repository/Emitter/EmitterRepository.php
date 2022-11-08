<?php


namespace App\Repository\Emitter;
use App\Models\Emitter;



class EmitterRepository
{
    /**
     * @var Emitter
     */
    private $emitter;


    public function __construct(Emitter $emitter)
    {


        $this->emitter = $emitter;
    }

    public function all()
    {
        $emitters = $this->emitter->orderBy('id', 'desc')->get();
        return $emitters;
    }


    public function findById($id)
    {
        $emitter = $this->emitter->find($id);
        return $emitter;
    }

    public function supervisorEmitters()
    {
        $emitters = $this->emitter->where('supervisor_id',auth()->id())->get();
        return $emitters;
    }



}
