<?php


namespace App\Repository\Organization;

use App\Models\Organization\Organization;
use App\Models\EnumeratorAssign\EnumeratorAssign;
use Illuminate\Support\Facades\DB;

class OrganizationRepository
{
    /**
     * @var Organization
     */
    private $organization;
    /**
     * @var EnumeratorAssign
     */
    private $enumeratorAssign;

    public function __construct(Organization $organization, EnumeratorAssign $enumeratorAssign)
    {

        $this->organization = $organization;
        $this->enumeratorAssign = $enumeratorAssign;
    }
    public function all($request)
    {
        $organizations = $this->organization
            ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
            ->leftjoin('emitters', 'enumeratorassign_pivot.emitter_id', 'emitters.id')
            ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id');

        if ($request->has('pradesh_id') && $request->pradesh_id != null) {
            $organizations = $organizations->where('organizations.pradesh_id', '=', $request->pradesh_id);
        }
        if ($request->has('district_id') && $request->district_id != null) {
            $organizations = $organizations->where('organizations.district_id', '=', $request->district_id);
        }
        if ($request->has('muni_id') && $request->muni_id != null) {
            $organizations = $organizations->where('organizations.muni_id', '=', $request->muni_id);
        }
        if ($request->has('enumerator_id') && $request->enumerator_id != null) {
            $organizations = $organizations->where('emitter_id', '=', $request->enumerator_id);
        }
        if ($request->has('survey_id') && $request->survey_id != null) {
            $organizations = $organizations->where('survey_id', '=', $request->survey_id);
        }
        if ($request->has('org_name') && $request->org_name != null) {
            $organizations = $organizations->where('org_name', 'LIKE', '%'.$request->org_name.'%');
        }

        $organizations = $organizations->select(
            'organizations.*',
            'enumeratorassign_pivot.organization_id',
            'enumeratorassign_pivot.survey_id',
            'enumeratorassign_pivot.id as emu_id',
            'enumeratorassign_pivot.emitter_id',
            'emitters.name',
            'surveys.survey_name'
        )->with('sector', 'district', 'pradesh')->orderBy('organizations.id', 'desc')->paginate(10)->appends(request()->query());

        return $organizations;
    }

    public function orgName()
    {
        $orgName = $this->organization->orderBy('id', 'asc')->get();
        return $orgName;
    }
    public function findById($id)
    {
        $organization = $this->organization->find($id);
        return $organization;
    }

    public function filter($request)
    {
        $enumeratorcheck = EnumeratorAssign::where('emitter_id', '=', $request->enumerator_id)->where('survey_id', '=', $request->survey_id)->first();
        if ($enumeratorcheck) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('emitters', 'enumeratorassign_pivot.emitter_id', 'emitters.id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id');
            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('organizations.pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('organizations.district_id', '=', $request->district_id);
            }



            // dd($organizations->get());
            $organizations = $organizations->select(
                'organizations.*',
                'enumeratorassign_pivot.organization_id',
                'enumeratorassign_pivot.survey_id',
                'enumeratorassign_pivot.id as emu_id',
                'enumeratorassign_pivot.emitter_id',
                'enumeratorassign_pivot.start_date',
                'enumeratorassign_pivot.finish_date',
                'emitters.name',
                'surveys.survey_name'
            )->orderBy('organizations.id', 'asc')->get();
            return $organizations;
        } else {
            // dd('uta');

            //          for ($i = 0; $i < count($request->survey_id); $i++) {
            //              $oldData = EnumeratorAssign::where('survey_id', $request->survey_id)->get();
            //          }

            $organizations = $this->organization;
            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }

            $organizations = $organizations->orderBy('id', 'asc')->get();
            //                  $enumeratorcheck=EnumeratorAssign::where('emitter_id','=',$request->enumerator_id)->where('survey_id','=',$request->survey_id)->first();

            return $organizations;
        }
    }

    public function filterreport($request)
    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->where('answers.deleted','0');

            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }

            $organizations = $organizations->select(
                'organizations.*',
                'enumeratorassign_pivot.organization_id',
                'enumeratorassign_pivot.survey_id',
                'enumeratorassign_pivot.id as emu_id',
                'enumeratorassign_pivot.emitter_id',
                'surveys.survey_name',
                'answers.answer',
                'answers.qsn_opt_id',
            )->orderBy('organizations.id', 'asc')->get();
            return $organizations;
        }
    }

    public function filterradio($request)
    {


        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->leftjoin('question_options', 'answers.qsn_opt_id', 'question_options.id')
                ->where('answers.deleted','0');

            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {
                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }

            $organizations = $organizations->where('enumeratorassign_pivot.status','supervised')->select(
                'surveys.survey_name',
                'answers.qsn_opt_id',
                'answers.qsn_id',
                'question_options.option_name',
                DB::raw("COUNT('answers.qsn_opt_id') as count")
            )->groupBy('answers.qsn_opt_id', 'surveys.survey_name', 'answers.qsn_id', 'question_options.option_name')->get();
            return $organizations;
        }
    }

    public function filterconditionalRadio($request, $quesType)
    {

        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->leftjoin('question_options', 'answers.qsn_opt_id', 'question_options.id')
                ->where('enumeratorassign_pivot.status','supervised')
                ->where('answers.deleted','0');

            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {
                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }
            if ($quesType == "8") {
                $organization1 = clone $organizations;
                $organization1 = $organization1->join('other_occupation_details', 'enumeratorassign_pivot.id', 'other_occupation_details.enumerator_assign_id');
                $data['condi_radio'] = $organizations->select(
                    'answers.qsn_opt_id',
                    'answers.qsn_id',
                    'question_options.option_name',
                    DB::raw("COUNT('answers.qsn_opt_id') as count")
                )->groupBy('answers.qsn_opt_id', 'answers.qsn_id', 'question_options.option_name')->get();

                $data['occupations_details'] = $organization1->select(
                    'answers.qsn_id',
                    'other_occupation_details.occupation_id',
                    DB::raw("Sum(other_occupation_details.present_demand) as present_demand"),
                    DB::raw("Sum(other_occupation_details.demand_two_year) as demand_two_year"),
                    DB::raw("Sum(other_occupation_details.demand_five_year) as demand_five_year"),
                )->groupBy('answers.qsn_id', 'other_occupation_details.occupation_id')->get();
                $organizations = $data;
            } else {
                $organizations = $organizations->select(
                    'answers.qsn_opt_id',
                    'answers.qsn_id',
                    'question_options.option_name',
                    DB::raw("COUNT('answers.qsn_opt_id') as count")
                )->groupBy('answers.qsn_opt_id', 'answers.qsn_id', 'question_options.option_name')->get();
            }
            return $organizations;
        }
    }

    public function filtercheckbox($request)

    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->where('answers.deleted','0')
                ->where('enumeratorassign_pivot.status','supervised');
            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {

                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }


            $organizations = $organizations->select(
                'surveys.survey_name',
                'answers.answer',
                'answers.other_answer',
                'answers.qsn_id',
                'organizations.id',
                'enumeratorassign_pivot.status',
                'enumeratorassign_pivot.id as e_id'
            )->get();
            return $organizations;
        }
    }

    public function filterinput($request)
    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')->where('enumeratorassign_pivot.status','supervised');

            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {
                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }

            $organizations = $organizations->select(
                'organizations.org_name',
                'surveys.survey_name',
                'answers.answer',
                'answers.qsn_id',
            )->orderBy('organizations.id', 'asc')->get();

            return $organizations;
        }
    }
    public function filtermultipleinput($request)
    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')->where('enumeratorassign_pivot.status','supervised');
            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {
                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }


            $organizations = $organizations->select(
                'surveys.survey_name',
                'answers.answer',
                'answers.qsn_id',
            )->get();

            return $organizations;
        }
    }

    public function filterexternal_table($request, $queson_no)
    {
        // dd('yeta');
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')->where('enumeratorassign_pivot.status','supervised');


            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($queson_no == '13') {
                $organizations = $organizations->leftjoin('worker_skills', 'enumeratorassign_pivot.id', 'worker_skills.enumerator_assign_id');

                $organizations = $organizations->select(
                    'worker_skills.formally_trained',
                    'worker_skills.formally_untrained',
                    'worker_skills.skill',
                    'organizations.org_name',
                    'surveys.survey_name',
                )->orderBy('organizations.id', 'asc')->get();

                $organizations = $organizations->groupBy('skill');
            }

            if ($queson_no == '6.b') {
                $organizations = $organizations->join('survey_emp_statuses', 'enumeratorassign_pivot.id', 'survey_emp_statuses.enumerator_assign_id');

                $organizations = $organizations->select(
                    'survey_emp_statuses.occupation_id',
                    DB::raw("Sum(survey_emp_statuses.working_number) as working_number"),
                    DB::raw("Sum(survey_emp_statuses.required_number) as required_number"),
                    DB::raw("Sum(survey_emp_statuses.for_two_years) as for_two_years "),
                    DB::raw("Sum(survey_emp_statuses.for_five_years) as for_five_years"),
                    DB::raw('Max(survey_emp_statuses.working_number) as max_working_number'),
                    DB::raw('Max(survey_emp_statuses.required_number) as max_required_number'),
                    DB::raw('Max(survey_emp_statuses.for_two_years) as max_for_two_years'),
                    DB::raw('Max(survey_emp_statuses.for_five_years) as max_for_five_years'),
                    DB::raw('Min(survey_emp_statuses.working_number) as min_working_number'),
                    DB::raw('Min(survey_emp_statuses.required_number) as min_required_number'),
                    DB::raw('Min(survey_emp_statuses.for_two_years) as min_for_two_years'),
                    DB::raw('Min(survey_emp_statuses.for_five_years) as min_for_five_years'),
                    DB::raw('Avg(survey_emp_statuses.working_number) as avg_working_number'),
                    DB::raw('Avg(survey_emp_statuses.required_number) as avg_required_number'),
                    DB::raw('Avg(survey_emp_statuses.for_two_years) as avg_for_two_years'),
                    DB::raw('Avg(survey_emp_statuses.for_five_years) as avg_for_five_years'),
                    DB::raw('STDDEV(survey_emp_statuses.working_number) as std_working_number'),
                    DB::raw('STDDEV(survey_emp_statuses.required_number) as std_required_number'),
                    DB::raw('STDDEV(survey_emp_statuses.for_two_years) as std_for_two_years'),
                    DB::raw('STDDEV(survey_emp_statuses.for_five_years) as std_for_five_years'),

                )->groupBy('survey_emp_statuses.occupation_id')->get();
            }
            if ($queson_no == "5.1" || $queson_no == "5.2" || $queson_no == "5.3") {
                $organizations = $organizations->join('human_resources', 'enumeratorassign_pivot.id', 'human_resources.enumerator_assign_id');
                if ($queson_no == "5.1") {
                    $organizations->where('human_resources.resource_type', 'employer');
                }
                if ($queson_no == "5.2") {
                    $organizations->where('human_resources.resource_type', 'family_member');
                }
                if ($queson_no == "5.3") {
                    $organizations->where('human_resources.resource_type', 'employees');
                }


                $organizations = $organizations->select(
                    'human_resources.resource_type',
                    'human_resources.working_type',
                    DB::raw("Sum(human_resources.total) as total"),
                    DB::raw("Sum(human_resources.male_count) as male_count"),
                    DB::raw("Sum(human_resources.female_count) as female_count"),
                    DB::raw("Sum(human_resources.minority_count) as minority_count "),
                    DB::raw("Sum(human_resources.nepali_count) as nepali_count"),
                    DB::raw("Sum(human_resources.neighboring_count) as neighboring_count"),
                    DB::raw("Sum(human_resources.foreigner_count) as foreigner_count"),
                    DB::raw("Min(human_resources.male_count) as min_male_count"),
                    DB::raw("Min(human_resources.female_count) as min_female_count"),
                    DB::raw("Min(human_resources.minority_count) as min_minority_count"),
                    DB::raw("Min(human_resources.nepali_count) as min_nepali_count"),
                    DB::raw("Min(human_resources.neighboring_count) as min_neighboring_count"),
                    DB::raw("Min(human_resources.foreigner_count) as min_foreigner_count"),
                    DB::raw("Max(human_resources.male_count) as max_male_count"),
                    DB::raw("Max(human_resources.female_count) as max_female_count"),
                    DB::raw("Max(human_resources.minority_count) as max_minority_count"),
                    DB::raw("Max(human_resources.nepali_count) as max_nepali_count"),
                    DB::raw("Max(human_resources.neighboring_count) as max_neighboring_count"),
                    DB::raw("Max(human_resources.foreigner_count) as max_foreigner_count"),
                    DB::raw("Avg(human_resources.male_count) as avg_male_count"),
                    DB::raw("Avg(human_resources.female_count) as avg_female_count"),
                    DB::raw("Avg(human_resources.minority_count) as avg_minority_count"),
                    DB::raw("Avg(human_resources.nepali_count) as avg_nepali_count"),
                    DB::raw("Avg(human_resources.neighboring_count) as avg_neighboring_count"),
                    DB::raw("Avg(human_resources.foreigner_count) as avg_foreigner_count"),
                    DB::raw("STDDEV(human_resources.male_count) as std_male_count"),
                    DB::raw("STDDEV(human_resources.female_count) as std_female_count"),
                    DB::raw("STDDEV(human_resources.minority_count) as std_minority_count"),
                    DB::raw("STDDEV(human_resources.nepali_count) as std_nepali_count"),
                    DB::raw("STDDEV(human_resources.neighboring_count) as std_neighboring_count"),
                    DB::raw("STDDEV(human_resources.foreigner_count) as std_foreigner_count"),

                )->groupBy(['human_resources.resource_type', 'human_resources.working_type'])->get()->groupBy(['resource_type', 'working_type']);
            }


            return $organizations;
        }
    }

    public function filtersector($request)
    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->leftjoin('question_options', 'answers.qsn_opt_id', 'question_options.id')
                ->leftjoin('economic_sectors', 'answers.answer', 'economic_sectors.id')
                ->where('enumeratorassign_pivot.status','supervised')
                ->where('answers.deleted',0);
            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($request->has('question_id') && $request->question_id != null) {
                $organizations = $organizations->where('answers.qsn_id', '=', $request->question_id);
            }
            $organizations = $organizations->select(
                'surveys.survey_name',
                'answers.qsn_id',
                'answers.answer',
                'economic_sectors.sector_name as option_name',
                DB::raw("COUNT('answers.answer') as count")
            )->groupBy('answers.qsn_id', 'surveys.survey_name', 'answers.answer', 'economic_sectors.sector_name')->get();
            return $organizations;
        }
    }

    public function filtersubqsn($request, $childquestion)
    {
        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')
                ->leftjoin('answers', 'enumeratorassign_pivot.id', 'answers.enumerator_assign_id')
                ->where('enumeratorassign_pivot.status','supervised')
                ->where('answers.deleted','0');

            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }

            $childarray = [];
            foreach ($childquestion as $value) {
                array_push($childarray, $value->id);
            }

            if ($childarray != null) {
                $organizations = $organizations->whereIn('answers.qsn_id', $childarray);
            }


            $organizations = $organizations->select(
                'surveys.survey_name',
                'answers.qsn_id',
                'answers.answer',

            )->orderBy('organizations.id', 'asc')->get();
            $organizations = $organizations->groupBy('qsn_id');

            return $organizations;
        }
    }

    public function getHumanResourceData($request, $question_number)
    {
        $male = [];
        $female = [];
        $minority = [];
        $nepali = [];
        $neighboring = [];
        $foreigner = [];


        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')->where('enumeratorassign_pivot.status','supervised');


            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }
            if ($question_number == "5.1" || $question_number == "5.2" || $question_number == "5.3") {
                $organizations = $organizations->join('human_resources', 'enumeratorassign_pivot.id', 'human_resources.enumerator_assign_id');
                if ($question_number == "5.1") {
                    $organizations->where('human_resources.resource_type', 'employer');
                }
                if ($question_number == "5.2") {
                    $organizations->where('human_resources.resource_type', 'family_member');
                }
                if ($question_number == "5.3") {
                    $organizations->where('human_resources.resource_type', 'employees');
                }

                $organizations = $organizations->select(
                    'human_resources.working_type',
                    'human_resources.male_count',
                    'female_count',
                    'minority_count',
                    'nepali_count',
                    'neighboring_count',
                    'foreigner_count'
                )->get()->groupBy('working_type');
                $a = [];
                foreach ($organizations as $key => $q) {
                    foreach ($q as $p) {
                        $male[$key][] = $p->male_count;
                        $female[$key][] = $p->female_count;
                        $minority[$key][] = $p->minority_count;
                        $nepali[$key][] = $p->nepali_count;
                        $foreigner[$key][] = $p->foreigner_count;
                        $neighboring[$key][] = $p->neighboring_count;
                        $a[$key]['male_q1'] =  Quartile_1($male[$key]);
                        $a[$key]['male_q2'] =  Quartile_2($male[$key]);
                        $a[$key]['male_q3'] =  Quartile_3($male[$key]);
                        $a[$key]['female_q1'] =  Quartile_1($female[$key]);
                        $a[$key]['female_q2'] =  Quartile_2($female[$key]);
                        $a[$key]['female_q3'] =  Quartile_3($female[$key]);
                        $a[$key]['minority_q1'] =  Quartile_1($minority[$key]);
                        $a[$key]['minority_q2'] =  Quartile_2($minority[$key]);
                        $a[$key]['minority_q3'] =  Quartile_3($minority[$key]);
                        $a[$key]['nepali_q1'] =  Quartile_1($nepali[$key]);
                        $a[$key]['nepali_q2'] =  Quartile_2($nepali[$key]);
                        $a[$key]['nepali_q3'] =  Quartile_3($nepali[$key]);
                        $a[$key]['foreign_q1'] =  Quartile_1($foreigner[$key]);
                        $a[$key]['foreign_q2'] =  Quartile_2($foreigner[$key]);
                        $a[$key]['foreign_q3'] =  Quartile_3($foreigner[$key]);
                        $a[$key]['neighbouring_q1'] =  Quartile_1($neighboring[$key]);
                        $a[$key]['neighbouring_q2'] =  Quartile_2($neighboring[$key]);
                        $a[$key]['neighbouring_q3'] =  Quartile_3($neighboring[$key]);
                    }
                }

                return $a;
            }
        }
    }

    public function getEmpStatusData($request, $queson_no)
    {
        $working = [];
        $required = [];
        $for_two_years = [];
        $for_five_years = [];

        if ($request->all() != null) {
            $organizations = $this->organization
                ->leftjoin('enumeratorassign_pivot', 'organizations.id', 'enumeratorassign_pivot.organization_id')
                ->leftjoin('surveys', 'enumeratorassign_pivot.survey_id', 'surveys.id')->where('enumeratorassign_pivot.status','supervised');


            if ($request->has('pradesh_id') && $request->pradesh_id != null) {
                $organizations = $organizations->where('pradesh_id', '=', $request->pradesh_id);
            }
            if ($request->has('district_id') && $request->district_id != null) {
                $organizations = $organizations->where('district_id', '=', $request->district_id);
            }
            if ($request->has('muni_id') && $request->muni_id != null) {
                $organizations = $organizations->where('muni_id', '=', $request->muni_id);
            }
            if ($request->has('survey_id') && $request->survey_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.survey_id', '=', $request->survey_id);
            }
            if ($request->has('organization_id') && $request->organization_id != null) {
                $organizations = $organizations->where('enumeratorassign_pivot.organization_id', '=', $request->organization_id);
            }


            if ($queson_no == '6.b') {
                $organizations = $organizations->join('survey_emp_statuses', 'enumeratorassign_pivot.id', 'survey_emp_statuses.enumerator_assign_id');

                $organizations = $organizations->select(
                    'survey_emp_statuses.occupation_id',
                    'survey_emp_statuses.working_number',
                    'survey_emp_statuses.required_number',
                    'survey_emp_statuses.for_two_years',
                    'survey_emp_statuses.for_five_years'
                

                )->get()->groupBy('occupation_id');
            }
            $list = [];
            foreach($organizations as $key => $organization){
                foreach($organization as $o)
                {
                    $working[$key][]= $o->working_number;
                    $required[$key][] = $o->required_number;
                    $for_two_years[$key][] = $o->for_two_years;
                    $for_five_years[$key][] = $o->for_five_years;
                    $list[$key]['working_q1'] = Quartile_1($working[$key]);
                    $list[$key]['working_q2'] = Quartile_2($working[$key]);
                    $list[$key]['working_q3'] = Quartile_3($working[$key]);

                    $list[$key]['required_q1'] = Quartile_1($required[$key]);
                    $list[$key]['required_q2'] = Quartile_2($required[$key]);
                    $list[$key]['required_q3'] = Quartile_3($required[$key]);

                    $list[$key]['for_two_years_q1'] = Quartile_1($for_two_years[$key]);
                    $list[$key]['for_two_years_q2'] = Quartile_2($for_two_years[$key]);
                    $list[$key]['for_two_years_q3'] = Quartile_3($for_two_years[$key]);

                    $list[$key]['for_five_years_q1'] = Quartile_1($for_five_years[$key]);
                    $list[$key]['for_five_years_q2'] = Quartile_2($for_five_years[$key]);
                    $list[$key]['for_five_years_q3'] = Quartile_3($for_five_years[$key]);
                }

                
            }

            return $list;
        }
    }
}
