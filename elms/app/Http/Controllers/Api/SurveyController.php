<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\SurveyListResource;
use App\Http\Resources\SurveyStatusResource;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use App\Models\FeedbackLog;
use App\Models\Survey\Survey;
use App\Repository\EnumeratorAssign\EnumeratorAssignRepository;
use App\Repository\Survey\SurveyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function __construct(SurveyRepository $surveyRepository, EnumeratorAssignRepository $enumeratorAssignRepository)
    {
        $this->surveyRepository = $surveyRepository;
        $this->enumeratorAssignRepository = $enumeratorAssignRepository;
    }
    /**
     * Get Recent Survey.
     *
     * This Api provides the recent survey to be done.Change bearer token according to user in header. Provides list of survey to be shown in the dashboard 
     *
     * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTgxMzYwYzUxMmViNTNhMDBkZDEyNGI2NzQwMjg0NDY4NzBkZTUyNWVkMDhiOGE0YjhhN2NhZGQ3MjVkYzQyZThmNzMwZDEzMjEwZDE2OWYiLCJpYXQiOjE2MzYzNjYyNDguMjM4OTUyLCJuYmYiOjE2MzYzNjYyNDguMjM4OTU1LCJleHAiOjE2Njc5MDIyNDguMjIxMDQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.JOPUHZSws9mDsAvw3AVDeNHWtKGcGsOKpk1raZM4fkm02n4wD2yBfcUL2ZjbNmWUDwiuILu9AVph59Z0xNO2qlgZ6Ob2pzgLja_J7wM3FALzrxwtqHYTSwIzUdVBDkhWoZBYoaEmWUR2t5lqqlIehjQ5HwpuaS1qRhWAObyZqb6x4Z3efk5sS0BjLapVcAObqXya2YXYoUjLybvIsRugwTq2jysDnj-BBBbqWM03MTW7Vv7b6xd5IIuobj3P2SuQJyK33tqXt3ArK-FI5BNCfW0xCJLDupjFYOfZ98t36qDUUSMrz_exfdogYZpCBicKY7J9oYu59dCj8imitaIxC5SOm9PabDOJaNtQan_kKZf5LP7c_tjanDxx0l1eXLqn1JO44Y0BATzJ6aTwWG_MYgyCr5ym6uFENHJJfKBHqG0i-wBIskZjHeHg-PJqdDkmQS5FfwG8d7d23_SjhVziz7aiOkOLEVBOEFGdkKUltuhS_iPwCcFOU-cGTJLQYfWnQZMJg3t_5zKntty5A4XY93CCZO6kg8H-6KPRW2Ki6xxHm800Y0keJsKgGaywfx-DUYMaEHMmp4-sMIHkvZf5EeDRfxVU0EkgLqLn6aKRwJut0_YE32W8QTnTVgkzF3aFgYB8RZg56TfCtkwgjhu0IaZ4c_BE2Tp46AEU4jeijdA
     * @response status=401 scenario="no token provided or token expired" {"message": "Unauthenticated"}
     **/
    public function recentSurvey(Request $request)
    {
        $request['enumerator_id'] = auth()->guard('api')->user()->id;
        try {
            $recent_survey = $this->surveyRepository->assignedSurvey($request);
            return response()->json(['data' => SurveyListResource::collection($recent_survey)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function organizations(Request $request, $id)
    {
        try {
            $request['enumerator_id'] = auth()->guard('api')->user()->id;
            $request['survey_id'] = $id;
            $organizations = $this->enumeratorAssignRepository->assignedOrganizaions($request);
            return response()->json(['data' => OrganizationResource::collection($organizations)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    /**
     * Start Survey .
     *
     * This api start the survey. 
     *
     * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTgxMzYwYzUxMmViNTNhMDBkZDEyNGI2NzQwMjg0NDY4NzBkZTUyNWVkMDhiOGE0YjhhN2NhZGQ3MjVkYzQyZThmNzMwZDEzMjEwZDE2OWYiLCJpYXQiOjE2MzYzNjYyNDguMjM4OTUyLCJuYmYiOjE2MzYzNjYyNDguMjM4OTU1LCJleHAiOjE2Njc5MDIyNDguMjIxMDQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.JOPUHZSws9mDsAvw3AVDeNHWtKGcGsOKpk1raZM4fkm02n4wD2yBfcUL2ZjbNmWUDwiuILu9AVph59Z0xNO2qlgZ6Ob2pzgLja_J7wM3FALzrxwtqHYTSwIzUdVBDkhWoZBYoaEmWUR2t5lqqlIehjQ5HwpuaS1qRhWAObyZqb6x4Z3efk5sS0BjLapVcAObqXya2YXYoUjLybvIsRugwTq2jysDnj-BBBbqWM03MTW7Vv7b6xd5IIuobj3P2SuQJyK33tqXt3ArK-FI5BNCfW0xCJLDupjFYOfZ98t36qDUUSMrz_exfdogYZpCBicKY7J9oYu59dCj8imitaIxC5SOm9PabDOJaNtQan_kKZf5LP7c_tjanDxx0l1eXLqn1JO44Y0BATzJ6aTwWG_MYgyCr5ym6uFENHJJfKBHqG0i-wBIskZjHeHg-PJqdDkmQS5FfwG8d7d23_SjhVziz7aiOkOLEVBOEFGdkKUltuhS_iPwCcFOU-cGTJLQYfWnQZMJg3t_5zKntty5A4XY93CCZO6kg8H-6KPRW2Ki6xxHm800Y0keJsKgGaywfx-DUYMaEHMmp4-sMIHkvZf5EeDRfxVU0EkgLqLn6aKRwJut0_YE32W8QTnTVgkzF3aFgYB8RZg56TfCtkwgjhu0IaZ4c_BE2Tp46AEU4jeijdA
     * 
     * @bodyParam pivot_id int required Pivot id. Example: 1
     * @bodyParam latitude string The latitude of the mobile location.
     * @bodyParam longitude string The longitude of the mobile location.
     * @response status=401 scenario="no token provided or token expired" {"message": "Unauthenticated"}
     **/
    public function startSurvey(Request $request)
    {
        try {
            $assignedEnumerator = EnumeratorAssign::findOrFail($request->pivot_id);
            $assignedEnumerator->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'start_date' => Carbon::now(),
            ]);
            return response()->json(['message' => 'Survey Started Successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function finishSurvey(Request $request)
    {
        try {
            $assignedEnumerator = EnumeratorAssign::findOrFail($request->pivot_id);
            $assignedEnumerator->update([
                'interview_date' => $request->interview_date,
                'respondent_name' => $request->respondent_name,
                'designation' => $request->designation,
                'finish_date' => Carbon::now()
            ]);
            return response()->json(['message' => 'Survey finished successfully'], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function surveyStatus()
    {

        try {
            $orgs['assigned'] = EnumeratorAssign::where('emitter_id', auth()->user()->id)->count();
            $orgs['started'] = EnumeratorAssign::where('emitter_id', auth()->user()->id)->where('start_date', '<>', 'NULL')->where('status','<>','supervised')->count();
            $orgs['completed'] = EnumeratorAssign::where('emitter_id', auth()->user()->id)->where('status', 'supervised')->count();
            return response()->json(['data' => new SurveyStatusResource($orgs)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }

    public function feedbackOrganization()
    {
        try {
            $data = EnumeratorAssign::where('emitter_id', auth()->user()->id)->where('status','feedback')->with('organization.pradesh','organization.sector')->get();
            return response()->json(['data'=>OrganizationResource::collection($data)]);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()],500);
        }
    }

    public function viewFeedback($id)
    {
        try {
            $data = FeedbackLog::where('enumerator_assign_id',$id)->get();
            return response()->json(['data'=>FeedbackResource::collection($data)]);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage(),500]);
        } 
    }
}
