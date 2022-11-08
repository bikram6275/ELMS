<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\MuniType;
use App\Models\Configuration\Municipality;
use App\Http\Requests\Configurations\MuniTypeRequest;
use App\Repository\Configurations\MuniTypeRepository;

class MuniTypeController extends Controller
{
    /**
     * @var MuniTypeRepository
     */
    private $muniTypeRepository;

    /**
     * MuniTypeController constructor.
     */
    public function __construct(MuniTypeRepository $muniTypeRepository)
    {
        
        $this->muniTypeRepository = $muniTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $muniTypes = $this->muniTypeRepository->all();
        return view('backend.configurations.muniType.index', compact('muniTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MuniTypeRequest $request)
    {
        try {
            $create = MuniType::create($request->all());
            if ($create) {
                session()->flash('success', 'Muni Type successfully created!');
                return back();
            } else {
                session()->flash('error', 'Muni type could not be created!');
                return back();
            }
        } catch (\Exception $e) {
            $e->getMessage();
            session()->flash('error', 'Exception : ' . $e);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = (int)$id;
            $edits = $this->muniTypeRepository->findById($id);
            if ($edits->count() > 0) {
                $muniTypes = $this->muniTypeRepository->all();
                return view('backend.configurations.muniType.index', compact('edits', 'muniTypes'));
            } else {
                session()->flash('error', 'Id could not be obtained!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MuniTypeRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $muniType = $this->muniTypeRepository->findById($id);
            if ($muniType) {
                $muniType->fill($request->all())->save();
                session()->flash('success', 'Muni Type updated successfully!');

                return redirect(route('muniType.index'));
            } else {

                session()->flash('error', 'No record with given id!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION:' . $exception);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = (int)$id;
        try {
            $value = $this->muniTypeRepository->findById($id);
            if ($value) {
                $valueId = $value->id;
                $result = Municipality::where('muni_type_id', $valueId)->get();

                if (count($result) > 0) {
                    session()->flash('error', 'Municipality Type is in use. Unable to delete!');
                    return back();
                }
            }
            $value->delete();
            session()->flash('success', 'Muni Type successfully deleted!');
            return back();
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }
}
