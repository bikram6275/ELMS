<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;

class AboutController extends Controller
{
    public function index()
    {
        try {
            $response = About::where('status','active')->get();
            return response()->json(['data' => AboutResource::collection($response)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }

    }
}
