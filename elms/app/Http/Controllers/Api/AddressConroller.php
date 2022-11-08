<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PradeshResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\MunicipalityResource;
use App\Models\Configuration\District;
use App\Models\Configuration\Municipality;
use App\Repository\Configurations\PradeshRepository;
use App\Repository\Configurations\DistrictRepository;

class AddressConroller extends Controller
{

    protected $district;

    protected $muni;

    public function __construct(PradeshRepository $pradeshRepository, DistrictRepository $districtRepository, District $district, Municipality $muni)
    {
        $this->pradeshRepository = $pradeshRepository;
        $this->districtRepository = $districtRepository;
        $this->district = $district;
        $this->muni = $muni;
    }

    public function pradesh()
    {
        try {
            $pradesh = $this->pradeshRepository->all();
            return response()->json([
                'data' => PradeshResource::collection($pradesh)
            ], 200);
        } catch (\Exception $th) {
            return response()->json([$th->getMessage(), 500]);
        }
    }

    public function district(Request $request)
    {
        try {

            $model = $this->district;
            if (isset($request['pradesh_id']) && $request['pradesh_id'] != null) {
                $model = $model->where('pradesh_id', $request['pradesh_id']);
            }
            $model = $model->get();
            return response()->json([
                'data' => DistrictResource::collection($model)
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage(), 500]);
        }
    }

    public function municipality(Request $request)
    {
        try {
            $model = $this->muni;
            if (isset($request['district_id']) && $request['district_id'] != null) {
                $model = $model->where('district_id', $request['district_id']);
            }
            $model = $model->get();
            return response()->json([
                'data' => MunicipalityResource::collection($model)
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage(), 500]);
        }
    }
}
