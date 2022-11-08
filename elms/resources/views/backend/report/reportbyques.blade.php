@extends('backend.layouts.app')
@section('title')
    Report
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Report By Question</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Report By Question</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Report By Question</h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open([
                                'method' => 'get',
                                route('reportbyquestions.index'),
                                'enctype' => 'multipart/form-data',
                                'file' => true,
                            ]) !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                        <label>Pradesh: </label>
                                        {{ Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('pradesh_id'), ['class' => 'form-control select2', 'id' => 'pradesh_id', 'name' => 'pradesh_id', 'placeholder' => 'Select Pradesh']) }}
                                        {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                        <label>District: </label>
                                        {{ Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('district_id'), ['class' => 'form-control select2', 'id' => 'district_id', 'name' => 'district_id', 'placeholder' => 'Select District']) }}
                                        {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('survey_id') ? 'has-error' : '' }}">
                                        <label>Survey: </label>
                                        {{ Form::select('survey_id', $surveys->pluck('survey_name', 'id'), Request::get('survey_id'), ['class' => 'form-control select2', 'id' => 'survey_id', 'placeholder' => 'Select Survey', 'required' => 'true']) }}
                                        {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('question_id') ? 'has-error' : '' }}">
                                        <label>Question: </label>
                                        {{ Form::select('question_id', $questions->pluck('qsn_name', 'id'), Request::get('question_id'), ['class' => 'form-control select2', 'id' => 'question_id', 'placeholder' => 'Select Question', 'required' => 'true']) }}
                                        {!! $errors->first('question_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info " id="search"><i
                                                class="fa fa-search"></i>Search
                                        </button>
                                        <a href="{{ url('/report/reportbyquestions/') }}" class="btn btn-warning"><i
                                                class="fa fa-refresh"></i> Refresh
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body col-md-12">
                            @if ($organizations != null)
                                <div class="row">
                                    <div class="col-md-12 card">
                                        <div class="card-header ">
                                            <h3 class=" font-weight-bold text-center">Report Summary
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="card">
                                                <div class="card-header ">
                                                    <h4 class="card-title font-weight-bold justify-content-center">Survey
                                                        Information
                                                    </h4>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group border-0">
                                                        <li class="list-group-item"> <b>Survey Name:</b> <br />
                                                            {{ $surveysQues->survey_name }}
                                                        </li>
                                                        <li class="list-group-item"> <b>Question :</b> <br />
                                                            {{ $questionfind->qsn_name }}
                                                        </li>
                                                        <li class="list-group-item"><b>Question Type :</b> &nbsp;
                                                            {{ $ansType[$questionfind->ans_type] }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($questionfind->ans_type == 'radio' ||
                                                $questionfind->ans_type == 'checkbox' ||
                                                $questionfind->ans_type == 'sector' ||
                                                $questionfind->ans_type == 'services' ||
                                                $questionfind->ans_type == 'multiple_input' ||
                                                $questionfind->ans_type == 'cond_radio')
                                                @if ($questionfind->qsn_number == '8')
                                                    <div class="col-md-12 card">
                                                        <div class="card-header ">
                                                            <h3 class=" card-title font-weight-bold">Conditional Answer
                                                                Response
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="pie_chart" class="mt-4">
                                                            </div>
                                                            <div class="table-responsive my-3">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <th> Answer</th>
                                                                        <th>Count</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($organizations as $organization)
                                                                            <tr>
                                                                                <td>{{ $organization['option_name'] }}
                                                                                </td>
                                                                                <td>{{ $organization['count'] }} </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12 card">
                                                        <div class="card-header ">
                                                            <h3 class=" card-title font-weight-bold">Other Answer Response
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="table-responsive my-3">
                                                                <table class="table table-striped mt-4">
                                                                    <thead>

                                                                        <th> Name of Occupations</th>
                                                                        <th>Present demand</th>
                                                                        <th>Estimated demand for next two years</th>
                                                                        <th>Estimated demand for next five years</th>
                                                                    </thead>

                                                                    <tbody>
                                                                        @foreach ($occupationsdetails as $key => $item)
                                                                            <tr>
                                                                                <td>{{ $occupation[$item->occupation_id] }}
                                                                                </td>
                                                                                <td>{{ $item->present_demand }}</td>
                                                                                <td>{{ $item->demand_two_year }}</td>
                                                                                <td>{{ $item->demand_five_year }}</td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @else
                                                    <div class="col-md-12 card">
                                                        <div class="card-body">
                                                            <div id="pie_chart" class="mt-4">
                                                            </div>
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <th> Answer</th>
                                                                    <th>Count</th>
                                                                    <th>Percentage</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $total_count = 0;
                                                                    $count_list = []; ?>
                                                                    <?php
                                                                    foreach ($organizations as $organization) {
                                                                        $count_list[] = $organization['count'];
                                                                        $total_count = array_sum($count_list);
                                                                    }
                                                                    
                                                                    ?>

                                                                    @foreach ($organizations as $organization)
                                                                        <tr>
                                                                            <td>{{ $organization['option_name'] }}</td>
                                                                            <td>{{ $organization['count'] }} </td>
                                                                            @if ($questionfind->ans_type == 'radio' || $questionfind->ans_type == 'sector')
                                                                                <td>{{ round(($organization['count'] / @$total_count) * 100, 2) }}%
                                                                                @elseif($questionfind->ans_type == 'checkbox' || $questionfind->ans_type == 'services')
                                                                                <td>{{ round(($organization['count'] / @$organization['total_response']) * 100, 2) }}%
                                                                            @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        @if ($questionfind->ans_type == 'checkbox' || $questionfind->ans_type == 'services')
                                                                            <td>Total Response</td>
                                                                            <td>{{ @$organizations[0]['total_response'] }}
                                                                            </td>
                                                                        @elseif($questionfind->ans_type == 'radio' || $questionfind->ans_type == 'sector')
                                                                            <td>Total </td>
                                                                            <td>{{ @$total_count }}</td>
                                                                        @endif
                                                                    </tr>

                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            @elseif ($questionfind->ans_type == 'input')
                                                <div class="col-md-12 card">
                                                    <div class="card-header ">
                                                        <h3 class="card-title font-weight-bold justify-content-center">
                                                            Survey Responses
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive my-3">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <th> Organizations</th>
                                                                    <th> Answer</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($organizations as $organization)
                                                                        <tr>
                                                                            <td>{{ $organization->org_name }}</td>
                                                                            <td>{{ $organization->answer }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($questionfind->ans_type == 'external_table')
                                                @if ($questionfind->qsn_number == '13')
                                                    <div class="col-md-12 card">
                                                        <div class="panel-body mt-4">
                                                            <div id="bar-chart" class="mt-4">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="table-responsive my-3">
                                                                    <table class="table table-striped">
                                                                        <thead class="text-center">
                                                                            <tr class="">
                                                                                <th rowspan="2"
                                                                                    style="vertical-align: middle">
                                                                                    Aspects</th>
                                                                                <th>Trained and Inexperienced</th>
                                                                                <th>Untrained and Experienced</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($organizations as $key => $organization)
                                                                                <tr>
                                                                                    <td>{{ $skills[$key] }}</td>
                                                                                    <td>{{ $organization['formally_trained'] }}
                                                                                    </td>
                                                                                    <td>{{ $organization['formally_untrained'] }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($questionfind->qsn_number == '6.b')
                                                    @include('backend.report.partial.employmentstatus')
                                                @elseif ($questionfind->qsn_number == '5.1' ||
                                                    $questionfind->qsn_number == '5.2' ||
                                                    $questionfind->qsn_number == '5.3')
                                                    @include('backend.report.partial.humanresource')
                                        </div>
                            @endif
                        @elseif ($questionfind->ans_type == 'sub_qsn')
                            <div class="col-md-12 card">
                                <div class="panel-body mt-4">
                                    <div id="single_bar-chart" class="mt-4">
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive my-3">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead class="text-center">
                                                    <tr class="b">
                                                        <th>S.N</th>
                                                        <th>
                                                            Membership with Associated Federation</th>
                                                        <th>Value</th>
                                                        <th>Percentage</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    {{-- {{ dd($organizations) }} --}}
                                                    @foreach ($organizations as $key => $organization)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            @foreach ($childquestion as $item)
                                                                @if ($item->id == $key)
                                                                    <td>
                                                                        {{ $item->qsn_name }}

                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                            <td>
                                                                {{ $organization }}
                                                            </td>
                                                            <td>{{ round(($organization / array_sum($organizations)) * 100, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot>
                                                    <tr class="font-weight-bold">
                                                        <td>Total</td>
                                                        <td></td>
                                                        <td>{{ array_sum($organizations) }}</td>
                                                        <td>100%</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card-body text-center">
                                    <p class="h4 text-capitalize text-danger">Question Type Not found</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="card-body text-center">
                                <p class="h4 text-capitalize">No data found</p>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function getDisByPradesh() {
                var district_option = '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{ url('/get/district/') }}/" + pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option +=
                                `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
                        });
                        var select_group = $('#district_id');
                        select_group.empty().append(district_option);
                        $('#district_id').prop('disabled', false);
                    },
                });
            }

            function getMuniByDis() {
                var muni_option = '<option value="">Select Municipality</option>';
                $('#municipality_id').prop('disabled', true);
                $.ajax({
                    url: "{{ url('/get/municipality/') }}/" + district_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var is_selected = value.id == municipality_id ?
                                'selected="selected"' : "";
                            muni_option +=
                                `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function() {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function() {
                district_id = $('#district_id').val();
                getMuniByDis();
            });

        });
    </script>
    <script src="{{ url('lib/HighCharts/code/highcharts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var answer = <?php echo json_encode($organizations); ?>;
            var options = {
                chart: {
                    renderTo: 'pie_chart',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false

                },
                title: {
                    text: 'Answer Range'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage}%</b>',
                    percentageDecimals: 1
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#000000',
                            connectorColor: '#000000',
                            formatter: function() {
                                return '<b>' + this.point.name + '</b>: ' + this.percentage
                                    .toFixed(2) +
                                    ' %';
                            }
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Answer'
                }]
            }
            myarray = [];
            $.each(answer, function(index, val) {
                myarray[index] = [val.option_name, val.count];
            });
            options.series[0].data = myarray;
            chart = new Highcharts.Chart(options);

        });
    </script>
    <script>
        $(function() {

            var answers = <?php echo json_encode($organizations); ?>;
            var skills = <?php echo json_encode($skills); ?>;
            myskills = [];
            $.each(skills, function(index, val) {
                myskills.push(val);
            });
            myarray = [];
            myarray['formally_trained'] = [];
            myarray['formally_untrained'] = [];

            $.each(answers, function(index, val) {
                myarray['formally_trained'].push(val.formally_trained);
                myarray['formally_untrained'].push(val.formally_untrained);

            });

            $('#bar-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Skills List'
                },
                xAxis: {
                    categories: myskills,
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'Skills'
                    }
                },
                series: [{
                        name: 'Formally Trained',
                        data: myarray['formally_trained']

                    },
                    {
                        name: 'Formally Untrained',
                        data: myarray['formally_untrained']

                    }
                ]
            });


        });
    </script>
    <script>
        $(function() {


            var occupation = <?php echo json_encode($occupation); ?>;
            var answers = <?php echo json_encode($organizations); ?>;
            mymultiarray = [];
            mymultiarray['occupation'] = [];
            mymultiarray['working'] = [];
            mymultiarray['required'] = [];
            mymultiarray['nxt_2_yrs'] = [];
            mymultiarray['nxt_5_yrs'] = [];

            $.each(answers, function(index, val) {

                answers[index]['occupation'] = occupation[val.occupation_id];
                mymultiarray['occupation'].push(answers[index].occupation);
                mymultiarray['working'].push(parseInt(val.working_number));
                mymultiarray['required'].push(parseInt(val.required_number));
                mymultiarray['nxt_2_yrs'].push(parseInt(val.for_two_years));
                mymultiarray['nxt_5_yrs'].push(parseInt(val.for_five_years));

            });


            $('#multi-bar-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'List'
                },
                xAxis: {
                    categories: mymultiarray['occupation'],
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'Number'
                    }
                },
                series: [{
                        name: 'Currently working numbers',
                        data: mymultiarray['working']
                    },
                    {
                        name: 'Currently Required Number',
                        data: mymultiarray['required']
                    },
                    {
                        name: 'Estimated Required For next two Years',
                        data: mymultiarray['nxt_2_yrs']
                    },

                    {
                        name: 'Estimated Required For next five Years',
                        data: mymultiarray['nxt_5_yrs']
                    }

                ]
            });


        });
    </script>

    <script>
        $(function() {
            var answers = <?php echo json_encode($organizations); ?>;
            var memebership = <?php echo json_encode($childquestion); ?>;
            mysinglearray = [];
            mysinglearray['membership'] = [];
            mysinglearray['count'] = [];

            $.each(answers, function(index, val) {

                mysinglearray['count'].push(val);
                $.each(memebership, function(key, value) {
                    if (value.id == index)
                        mysinglearray['membership'].push(value.qsn_name);
                });


            });

            $('#single_bar-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'List'
                },
                xAxis: {
                    categories: mysinglearray['membership'],
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'Number'
                    }
                },
                series: [{
                        name: '',
                        data: mysinglearray['count']
                    }

                ]
            });
        });
    </script>
    <script>
        $(function() {


            var occupation = <?php echo json_encode($occupation); ?>;
            var answers = <?php echo json_encode($occupationsdetails); ?>;
            console.log(answers);
            mymultiarray = [];
            mymultiarray['occupation'] = [];
            mymultiarray['present_demand'] = [];
            mymultiarray['nxt_2_yrs'] = [];
            mymultiarray['nxt_5_yrs'] = [];

            $.each(answers, function(index, val) {

                answers[index]['occupation'] = occupation[val.occupation_id];
                mymultiarray['occupation'].push(answers[index]['occupation']);
                mymultiarray['present_demand'].push(parseInt(val.present_demand));
                mymultiarray['nxt_2_yrs'].push(parseInt(val.demand_two_year));
                mymultiarray['nxt_5_yrs'].push(parseInt(val.demand_five_year));

            });


            $('#occupation-bar-chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'List'
                },
                xAxis: {
                    categories: mymultiarray['occupation'],
                    crosshair: true
                },
                yAxis: {
                    title: {
                        text: 'Number'
                    }
                },
                series: [{
                        name: 'Present Demand',
                        data: mymultiarray['present_demand']
                    },
                    {
                        name: 'Estimated demand for next two years',
                        data: mymultiarray['nxt_2_yrs']
                    },
                    {
                        name: 'Estimated demand for next five years',
                        data: mymultiarray['nxt_5_yrs']
                    },

                ]
            });


        });
    </script>
@endsection
