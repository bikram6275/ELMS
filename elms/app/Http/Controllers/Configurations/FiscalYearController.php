<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configuration\FiscalYear;
use App\Http\Requests\Configurations\FiscalYearRequest;
use App\Repository\Configurations\FiscalYearRepository;

class FiscalYearController extends Controller
{
    /**
     * @var FiscalYearRepository
     */
    /**
     * @var FiscalYear
     */
    /**
     * @var FiscalYear|FiscalYearRepository
     */
    private $fiscalYearRepository;
    /**
     * @var FiscalYear
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(FiscalYearRepository $fiscalYearRepository)
    {
        

        $this->fiscalYearRepository = $fiscalYearRepository;
    }


    public function index()
    {
        $fiscalYears = $this->fiscalYearRepository->all();
        return view('backend.configurations.fiscalYear.index', compact('fiscalYears'));
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
    public function store(FiscalYearRequest $request)
    {
        try {
            $create = FiscalYear::create($request->all());
            if ($create) {
                session()->flash('success', 'Fiscal Year successfully created!');
                return back();
            } else {
                session()->flash('error', 'Fiscal Year could not be created!');
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
            $edits = $this->fiscalYearRepository->findById($id);
            if ($edits->count() > 0) {
                $fiscalYears = $this->fiscalYearRepository->all();
                return view('backend.configurations.fiscalYear.index', compact('edits', 'fiscalYears'));
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
    public function update(FiscalYearRequest $request, $id)
    {
        $id = (int)$id;
        try {
            $fiscalYear = $this->fiscalYearRepository->findById($id);
            if ($fiscalYear) {
                $fiscalYear->fill($request->all())->save();
                session()->flash('success', 'Fiscal Year updated successfully!');

                return redirect(route('fiscalYear.index'));
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

            if (FiscalYear::destroy($id)) {
                session()->flash('success', 'Fiscal Year successfully deleted!');
                return back();
            } else {
                session()->flash('error', 'Fiscal Year could not be deleted!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION' . $exception);
            return back();
        }
    }



    public function status($id)
    {
        try {
            $id = (int)$id;
            $fiscalYear = $this->fiscalYearRepository->findById($id);
            if ($fiscalYear->fy_status == 'inactive') {
                $fiscalYear->fy_status = 'active';
                $fiscalYear->save();
                session()->flash('success', 'Fiscal Year has been Activated!');
                return back();
            } else {
                $fiscalYear->fy_status = 'inactive';
                $fiscalYear->save();
                session()->flash('success', 'Fiscal Year has been Deactivated!');
                return back();
            }
        } catch (\Exception $e) {
            $exception = $e->getMessage();
            session()->flash('error', 'EXCEPTION :' . $exception);
        }
    }
}
