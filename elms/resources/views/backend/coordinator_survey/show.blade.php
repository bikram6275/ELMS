@extends('backend.layouts.app')
@section('title')
    Survey Answer
@endsection
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row pt-3">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Survey</h3>

                                <a href="{{ URL::previous() }}" class="pull-right boxTopButton" data-toggle="tooltip"
                                    title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                                @if (!isset($is_supervisor))
                                    <button type="button" id="printBtn" class="btn btn-primary btn-sm pull-right ml-2 mr-2"
                                        onclick="printDiv('printDivId')">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </button>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5><label class="font-weight-bold">Establishing Employers’ Led Labour Market Secretariat</label>
                        </h5>
                    </div>
                    <div class="col-md-12 text-center">
                        <h6><label class="text-primary font-weight-bold">{{ $assignedOrganization->survey->survey_name }}
                            </label></h6>
                    </div>
                    <br>
                    <div class="col-md-12 text-left">
                        <h6><label class="">1. General Information of Enterprises </label></h6>
                    </div>
                    <br>
                    <div class="col-md-6 text-left">
                        <p class="" style="text-indent :2em;"><strong>a) Name of Enterprise</strong> :
                            {{ $org_details->org_name }} </p>
                    </div>
                    <div class="col-md-6 text-left">
                        <p class="" style="text-indent :2em;"><strong>b. Province</strong> :
                            {{ $org_details->pradesh->pradesh_name }} </p>
                    </div>
                    <div class="col-md-6 text-left">
                        <p class="" style="text-indent :2em;"><strong>c. District</strong> :
                            {{ $org_details->district->english_name }} </p>
                    </div>
                    <div class="col-md-6 text-left">
                        <p class="" style="text-indent :2em;"><strong>b. Economic Sector</strong> :
                            {{ $org_details->sector->sector_name }} </p>
                    </div>
                </div>
                <br>
                @foreach ($questions as $question)
                    @if ($question->answer != null && isset($question->answer[0]))
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <h6><label class="">{{ $question->qsn_number }}.
                                        {{ $question->qsn_name }}</label>
                                </h6>
                            </div>
                            <div class="col-md-12 text-left">
                                @if ($question->ans_type == 'checkbox')
                                    <?php $result = explode(',', $question->answer[0]->answer); ?>
                                    @foreach ($question->questionOption as $option)
                                        @foreach ($result as $res)
                                            @if ($res == $option->id)
                                                <p class="" style="text-indent :2em;">-
                                                    {{ $option->option_name }},
                                                    {{ $option->option_name == 'Others' ? $question->answer[0]->other_answer : null }}
                                                </p>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @elseif($question->ans_type == 'radio')
                                    @foreach ($question->questionOption as $option)
                                        @if ($question->answer[0]->qsn_opt_id == $option->id)
                                            <p class="" style="text-indent :2em;">-
                                                @if ($question->qsn_number == 21)
                                                    {{ $option->option_name }} &nbsp;&nbsp;-
                                                    {{ $question->answer[0]->other_answer }}
                                                @else
                                                    {{ $option->option_name }}
                                                @endif
                                                @if ($question->qsn_number == 10 && $question->answer[0]->other_answer)
                                                    <div style="text-indent :2em;">
                                                        <h6> <span class="font-weight-bold"> Other Value :
                                                            </span>{{ $question->answer[0]->other_answer }}</h6>
                                                    </div>
                                                @endif
                                            </p>
                                        @endif
                                    @endforeach
                                @elseif($question->ans_type == 'sector')
                                    <p class="" style="text-indent :2em;">-
                                        {{ $allsectors[$question->answer[0]->answer] }}
                                    </p>
                                @elseif($question->ans_type == 'services')
                                    <?php $result = explode(',', $question->answer[0]->answer); ?>
                                    @foreach ($result as $res)
                                        @if (isset($services[$res]))
                                            <p class="" style="text-indent :2em;">-
                                                {{ $services[$res] }},
                                            </p>
                                        @endif
                                    @endforeach
                                    @if($question->answer[0]->other_answer!=null)
                                    <p class="" style="text-indent :2em;">-
                                                <span class="font-weight-bold">Others: </span>{{ $question->answer[0]->other_answer }},
                                            </p>
                                    @endif
                                @elseif ($question->ans_type == 'multiple_input')
                                    <?php $result3 = (array) json_decode($question->answer[0]->answer); ?>

                                    @foreach ($question->questionOption as $key => $value)
                                        <div class="form-group row  mt-3 " style="text-indent :2em;">
                                            <label
                                                class="{{ $question->qsn_number == 20 || $question->qsn_number == 12 ? 'col-sm-6' : 'col-sm-1' }}">{{ $value->option_number }}.
                                                {{ $value->option_name }}</label>
                                            {{ array_key_exists($value->id, $result3) ? $result3[$value->id] : null }}
                                        </div>
                                    @endforeach
                                @elseif ($question->ans_type == 'range')
                                    <?php $result2 = (array) json_decode($question->answer[0]->answer); ?>
                                    <div class="col-md-12 ">
                                        @foreach ($question->questionOption as $key => $value)
                                            <div class="form-group row mx-3 mt-3 " style="text-indent :2em;">
                                                <label class="col-sm-6">{{ $value->option_number }}.
                                                    {{ $value->option_name }}</label>
                                                {{ $result2[$value->id] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($question->ans_type == 'cond_radio')
                                    @if ($question->qsn_number == 9)
                                        @foreach ($question->questionOption as $option1)
                                            @if ($question->answer[0]->qsn_opt_id == $option1->id)
                                                <p class="" style="text-indent :2em;">-
                                                    {{ $option1->option_name }}
                                                </p>
                                            @endif
                                        @endforeach

                                        @if ($question->answer[0]->qsn_opt_id == 41)
                                            @if ($question->children != null)
                                                <div>
                                                    @foreach ($question->children as $child)
                                                        <label class="text-left">{{ $child->qsn_number }}.
                                                            {{ $child->qsn_name }}</label><br>

                                                        <div class="col-md-12 text-left">
                                                            <p class="" style="text-indent :4em;">
                                                                - @if (count($child->answer) > 0)
                                                                    {!! $child->answer[0]->answer !!}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    @elseif($question->qsn_number == 17)
                                        @foreach ($question->questionOption as $option1)
                                            @if ($question->answer[0]->qsn_opt_id == $option1->id)
                                                <p class="" style="text-indent :2em;">-
                                                    {{ $option1->option_name }}
                                                </p>
                                            @endif
                                        @endforeach

                                        @if ($question->answer[0]->qsn_opt_id == 73)
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Sector</th>
                                                            <th>Technology</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <tr>
                                                            {{-- <td>{{ $allsectors[$technology_details->sector->parent_id] }} --}}
                                                            </td>
                                                            <td>{{ $technology_details->sector ? $technology_details->sector->sector_name : '-' }}
                                                            </td>
                                                            <td>{{ $technology_details->technology }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @elseif($question->qsn_number == 18)
                                        @foreach ($question->questionOption as $option1)
                                            @if ($question->answer[0]->qsn_opt_id == $option1->id)
                                                <p class="" style="text-indent :2em;">-
                                                    {{ $option1->option_name }}
                                                </p>
                                            @endif
                                        @endforeach

                                        @if ($question->answer[0]->qsn_opt_id == 89)
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>Sector</th>
                                                            <th>Proposed Occupation</th>
                                                            <th>Skilled Level</th>
                                                            <th>Required Number</th>
                                                            <th>Possibility to incorporate green skills
                                                                components/occupations</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">

                                                        @foreach ($business_plans as $val)
                                                            <tr>
                                                                <td>{{ $val->sector->sector_name }}</td>
                                                                <td>{{ $val->occupation->occupation_name }}</td>
                                                                <td>{{ $val->level }}</td>
                                                                <td>{{ $val->required_number }}</td>
                                                                <td>{{ $val->incorporate_possible }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @elseif ($question->qsn_number == 8)
                                        @foreach ($question->questionOption as $option1)
                                            @if ($question->answer[0]->qsn_opt_id == $option1->id)
                                                <p class="" style="text-indent :2em;">-
                                                    {{ $option1->option_name }}
                                                </p>
                                            @endif
                                        @endforeach

                                        @if ($question->answer[0]->qsn_opt_id == 38)
                                            <div class="row">
                                                <table class="table table-bordered" id="occupationTable"
                                                    style="text-indent :2em;">
                                                    <thead>
                                                        <tr>
                                                            <th>Name of Occupations </th>
                                                            <th>Other Occupation Value</th>
                                                            <th>Present demand </th>
                                                            <th>Estimated demand for next two years </th>
                                                            <th>Estimated demand for next five years</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody class="text-center">
                                                        @if ($othter_occupationAnswer != null && count($othter_occupationAnswer) > 0)
                                                            @foreach ($othter_occupationAnswer as $key => $value)
                                                                <tr>
                                                                    <td>{{ $value->occupation ? $value->occupation->occupation_name : '-' }}
                                                                    </td>
                                                                    <td>{{ $value->other_value ? $value->other_value : '-' }}
                                                                    </td>
                                                                    <td>{{ $value->present_demand }}</td>
                                                                    <td>{{ $value->demand_two_year }}</td>
                                                                    <td>{{ $value->demand_five_year }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    <p class="" style="text-indent :2em;">-
                                        {{ $question->answer[0]->answer }} </p>
                                @endif
                            </div>
                        </div>
                    @elseif($question->ans_type == 'sub_qsn')
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <h6><label class="">{{ $question->qsn_number }}.
                                        {{ $question->qsn_name }}
                                    </label></h6>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Federations</th>
                                    <th colspan="2" style="text-align: center">Membership since</th>
                                </tr>
                                @foreach ($question->children as $key => $value)
                                    <?php $result2 = count($value->answer) > 0 ? (array) json_decode($value->answer[0]->answer) : null; ?>
                                    <tr>
                                        <td style="text-indent :2em;"><strong>{{ $value->qsn_number }}.
                                                {{ $value->qsn_name }}</strong></td>
                                        @foreach ($value->questionOption as $option)
                                            <td><strong> {{ $option->option_name }} : </strong>
                                                {{ $result2 != null ? $result2[$option->id] : '' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    @elseif($question->ans_type == 'external_table')
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <h6><label class="">{{ $question->qsn_number }}.
                                        {{ $question->qsn_name }}</label>
                                </h6>
                            </div>

                        </div>
                        @if ($question->qsn_number == 5.1 || $question->qsn_number == 5.2 || $question->qsn_number == 5.3)
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle">S.N</th>
                                        <th rowspan="2" style="vertical-align: middle">Nature of Human Resources
                                        </th>
                                        <th colspan="3">Gender</th>
                                        <th colspan="3">Nationality</th>
                                        <th rowspan="2" style="vertical-align: middle">Total Staff</th>
                                    </tr>
                                    <tr>
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Sexual Minority</th>
                                        <th>Nepali</th>
                                        <th>Neighboring Countries</th>
                                        <th>Foreigner</th>

                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @php $i=1; @endphp
                                    @foreach ($workers as $key => $worker)
                                        <tr>

                                            <td>{{ $i++ }}</td>

                                            <td>{{ $worker }}</td>
                                            {{-- {{ dd($answer) }} --}}
                                            @if ($question->qsn_number == 5.1)
                                                <td> {{ $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['male_count'] : 0 }}
                                                </td>

                                                <td>
                                                    {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['female_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['minority_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['nepali_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['neighboring_count'] : 0 !!}
                                                </td>
                                                <td> {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['foreigner_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $answer != null && (isset($answer[$key]) && isset($answer[$key])) ? $answer[$key][0]['total'] : 0 !!}
                                                </td>
                                            @elseif($question->qsn_number == 5.2)
                                                <td> {{ $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['male_count'] : 0 }}
                                                </td>

                                                <td>
                                                    {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['female_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['minority_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['nepali_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['neighboring_count'] : 0 !!}
                                                </td>
                                                <td> {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['foreigner_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $family_answer != null && (isset($family_answer[$key]) && isset($family_answer[$key])) ? $family_answer[$key][0]['total'] : 0 !!}
                                                </td>
                                            @else
                                                <td> {{ $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['male_count'] : 0 }}
                                                </td>

                                                <td>
                                                    {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['female_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['minority_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['nepali_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['neighboring_count'] : 0 !!}
                                                </td>
                                                <td> {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['foreigner_count'] : 0 !!}
                                                </td>
                                                <td>
                                                    {!! $employee_answer != null && (isset($employee_answer[$key]) && isset($employee_answer[$key])) ? $employee_answer[$key][0]['total'] : 0 !!}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <br>
                        @elseif($question->qsn_number == '6.a')
                            <div class="row">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Employee Name</th>
                                            <th>Gender </th>
                                            <th>Occupations </th>
                                            <th>Other Occupation Value</th>
                                            <th>Working Hours </th>
                                            <th>Nature of Work </th>
                                            <th>Training </th>
                                            <th>Educational Qualification (General) </th>
                                            <th>Educational Qualification (TVET) </th>
                                            <th>Work experience in present position </th>
                                            <th>Work experience in this occupation </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($technicalAnswer) > 0)
                                            @foreach ($technicalAnswer as $key => $value)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->emp_name }}</td>
                                                    <td>{{ $value->gender == 'male' ? 'Male' : 'Female' }}</td>
                                                    <td>{{ $value->occupation->occupation_name }}</td>
                                                    <td>{{ $value->occupation->occupation_name == 'Others' ? $value->other_occupation_value : '-' }}
                                                    </td>
                                                    <td>{{ $value->working_time == 'part' ? 'Part Time' : 'Full Time' }}
                                                    </td>
                                                    <td>{{ $value->work_nature == 'regular' ? 'Regular' : 'Seasonal' }}
                                                    </td>
                                                    <td>{{ $value->training == 'untrained' ? 'Untrained' : 'Trained' }}
                                                    </td>
                                                    <td>{{ $value->generalEducation->name }}</td>
                                                    <td>{{ $value->tvetEducation->name }}</td>
                                                    <td>{{ $value->work_exp1 }} </td>
                                                    <td>{{ $value->work_exp2 }} </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" style="text-align: center" class="text-danger">Data Not
                                                    Found!!</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @elseif($question->qsn_number == '6.b')
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Sector</th>
                                            <th>Occupation</th>
                                            <th>Currently Working Number</th>
                                            <th>Currently Required Number</th>
                                            <th>Estimated Required For next two Years</th>
                                            <th>Estimated Required For next five Years</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($empStatusAnswer) > 0)
                                            @foreach ($occupations as $occupation)
                                                <tr>
                                                    <td>{{ $occupation->sector_name }}</td>
                                                    <td>{{ $occupation->occupation->occupation_name }}</td>
                                                    <td>{!! isset($empStatusAnswer[$occupation->occupation_id]) ? $empStatusAnswer[$occupation->occupation_id][0]->working_number : null !!}</td>
                                                    <td>{!! isset($empStatusAnswer[$occupation->occupation_id]) ? $empStatusAnswer[$occupation->occupation_id][0]->required_number : null !!}</td>
                                                    <td>{!! isset($empStatusAnswer[$occupation->occupation_id]) ? $empStatusAnswer[$occupation->occupation_id][0]->for_two_years : null !!}</td>
                                                    <td>{!! isset($empStatusAnswer[$occupation->occupation_id]) ? $empStatusAnswer[$occupation->occupation_id][0]->for_five_years : null !!}</td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="text-align: center" class="text-danger">Data Not
                                                    Found!!</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @elseif($question->qsn_number == '13')
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>Aspects</th>
                                        <th>Trained but Inexperienced</th>
                                        <th>Untrained but Experienced)</th>
                                    </tr>
                                <tbody>
                                    @foreach ($skills as $key => $skill)
                                        <tr>
                                            <th>{{ $skill }}</th>
                                            <td>{{ $skillAnswer != null && isset($skillAnswer[$key]) ? $skillAnswer[$key][0]['formally_trained'] : 0 }}
                                            </td>
                                            <td>
                                                {{ $skillAnswer != null && isset($skillAnswer[$key]) ? $skillAnswer[$key][0]['formally_untrained'] : 0 }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </thead>
                            </table>
                        @endif
                    @endif
                @endforeach

            </div>
            <hr>
            @if (isset($is_coordinator) && $is_coordinator && isset($is_field_supervised) && $is_field_supervised)
                <div class="row justify-content-center ">
                    <div class="col-md-12">
                        {!! Form::open(['method' => 'post', 'url' => 'field_response/' . request()->id . '/feedback']) !!}
                        <div class="form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
                            <label for="">Remarks</label>
                            {{ Form::textarea('remarks', Request::get('remarks'), [
                                'class' => 'form-control ',
                                'id' => 'remarks',
                                'name' => 'remarks',
                                'placeholder' => 'Remarks or feedbacks',
                            ]) }}
                            {!! $errors->first('remarks', '<span class="text-danger">:message</span>') !!}
                        </div>
                        <button type="submit" name="return_back" class="btn btn-info mb-2"></i>Return Back</button>

                        <a name="approve" class="btn btn-primary mb-2"
                            href="{{ route('field.approve', request()->id) }}"> Approve</a>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
            <hr>
            <h1>Feedback History</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Status</th>
                        <th scope="col">Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $feedback->status }}</td>
                            <td>{{ $feedback->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>

@endsection
@push('custom-scripts')
    <script type="text/javascript">
        function printDiv() {
            $('#listing').hide();
            $('.main-footer').hide();
            window.print();
            $('#listing').show();
            $('.main-footer').show();
        }
    </script>
@endpush
