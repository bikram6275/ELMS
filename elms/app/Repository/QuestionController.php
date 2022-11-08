<?php

namespace App\Http\Controllers\Api;

use App\Models\Answers;
use Illuminate\Http\Request;
use App\Models\SurveyEmpStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repository\QuestionRepository;
use App\Http\Resources\QuestionResource;
use App\Models\EconomicSector\EconomicSector;
use App\Models\EnumeratorAssign\EnumeratorAssign;

class QuestionController extends Controller
{
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    /**
     * Get Questions.
     *
     * This Api provides list of questions along with ansewer (if already answered i.e edit answers). Provide survey_id and pivot_id in the route.
     * There are 8 types of questions (input, checkbox, radio, multiple_input,cond_radio, sector, external_table, sub_qsn)
     * @header Authorization Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYTgxMzYwYzUxMmViNTNhMDBkZDEyNGI2NzQwMjg0NDY4NzBkZTUyNWVkMDhiOGE0YjhhN2NhZGQ3MjVkYzQyZThmNzMwZDEzMjEwZDE2OWYiLCJpYXQiOjE2MzYzNjYyNDguMjM4OTUyLCJuYmYiOjE2MzYzNjYyNDguMjM4OTU1LCJleHAiOjE2Njc5MDIyNDguMjIxMDQyLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.JOPUHZSws9mDsAvw3AVDeNHWtKGcGsOKpk1raZM4fkm02n4wD2yBfcUL2ZjbNmWUDwiuILu9AVph59Z0xNO2qlgZ6Ob2pzgLja_J7wM3FALzrxwtqHYTSwIzUdVBDkhWoZBYoaEmWUR2t5lqqlIehjQ5HwpuaS1qRhWAObyZqb6x4Z3efk5sS0BjLapVcAObqXya2YXYoUjLybvIsRugwTq2jysDnj-BBBbqWM03MTW7Vv7b6xd5IIuobj3P2SuQJyK33tqXt3ArK-FI5BNCfW0xCJLDupjFYOfZ98t36qDUUSMrz_exfdogYZpCBicKY7J9oYu59dCj8imitaIxC5SOm9PabDOJaNtQan_kKZf5LP7c_tjanDxx0l1eXLqn1JO44Y0BATzJ6aTwWG_MYgyCr5ym6uFENHJJfKBHqG0i-wBIskZjHeHg-PJqdDkmQS5FfwG8d7d23_SjhVziz7aiOkOLEVBOEFGdkKUltuhS_iPwCcFOU-cGTJLQYfWnQZMJg3t_5zKntty5A4XY93CCZO6kg8H-6KPRW2Ki6xxHm800Y0keJsKgGaywfx-DUYMaEHMmp4-sMIHkvZf5EeDRfxVU0EkgLqLn6aKRwJut0_YE32W8QTnTVgkzF3aFgYB8RZg56TfCtkwgjhu0IaZ4c_BE2Tp46AEU4jeijdA
     * @param \Illuminate\Http\Request  $request
     * @urlParam id integer required The ID of the survey. Example: 1
     * @urlParam pivot_id integer required The Pivot Id. Example: 1
     * @response status=401 scenario="no token provided or token expired" {"message": "Unauthenticated"}
     **/
    public function index(Request $request)
    {
        try {
            $question = $this->questionRepository->apiQuestions();
            return response()->json(['data' => QuestionResource::collection($question)], 200);
        } catch (\Exception $ex) {
            return response()->json([$ex->getMessage()], 500);
        }
    }
    public function test()
    {
        // $sector =SurveyEmpStatus::select(DB::raw('sum(required_number) as sum'), 'economic_sectors.sector_name')
        // ->join('enumeratorassign_pivot', 'survey_emp_statuses.enumerator_assign_id', '=', 'enumeratorassign_pivot.id')
        // ->join('organizations', 'enumeratorassign_pivot.organization_id', '=', 'organizations.id')
        // ->join('economic_sectors','organizations.sector_id','=','economic_sectors.id')
        // ->groupBy('economic_sectors.sector_name')
        // ->get();
        $s = EconomicSector::select(
            DB::raw('IFNULL(sum(required_number),0) as sum', ''),
            DB::raw('IFNULL(sum(working_number),0) as W_sum'),
            DB::raw('IFNULL(sum(for_two_years),0) as t_sum'),
            DB::raw('IFNULL(sum(for_five_years),0) as f_sum'),
            'economic_sectors.sector_name'
        )
            ->leftJoin('organizations', 'organizations.sector_id', '=', 'economic_sectors.id')
            ->leftJoin('enumeratorassign_pivot', 'enumeratorassign_pivot.organization_id', '=', 'organizations.id')
            ->leftJoin('survey_emp_statuses', 'survey_emp_statuses.enumerator_assign_id', '=', 'enumeratorassign_pivot.id')->where('parent_id', 0)
            ->groupBy('economic_sectors.sector_name');

        $sector = $s->get();
        // $chart_label = $s->pluck('sector_name');
        // $chart_data = $s->pluck('sum','W_sum','t_sum','f_sum');
        return $sector;
    }
}
