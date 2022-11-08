@extends('backend.layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
@inject('survey_helper','App\Http\Helpers\SurveyHelper')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline" style="overflow-x: scroll">
                        <div class="card-header">
                            <h3 class="card-title">
                                Survey Status
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body ">
                            {!! Form::open(['method' => 'get', route('enumerator.org'), 'enctype' => 'multipart/form-data']) !!}
                            <div class="row">
                                <div class=" col-md-4 form-group">
                                    {!! Form::select('survey_id',$survey_helper->dropdown(), Request::get('survey_id'), [
                                        'class' => 'form-control select2',
                                        'id' => 'survey_id',
                                        'placeholder' => 'Select Survey',
                                    ]) !!}
                                </div>
                                <div class=" col-md-6text-center">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div class="row mt-4 mx-2">
                                <div class="col-md-3">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['total'] }}</h3>
                                            <p>Total Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['complete'] }}</h3>
                                            <p>Completed Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['inprogress'] }}</h3>
                                            <p>In Progress Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-spinner"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['incomplete'] }}
                                            </h3>
                                            <p>Not Started Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-exclamation"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mx-2">
                                <div class="col-md-3">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['enumerator'] }}</h3>
                                            <p>Enumerator Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['supervisor'] }}</h3>
                                            <p>Supervisor Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['coordinator'] }}</h3>
                                            <p>Coordiantor Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-spinner"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['feedback'] }}</h3>
                                            <p>Feedback Provided</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-exclamation"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <a class="btn btn-sm btn-primary float-right" href="{{ route('survey_status.view') }}">
                                    View More</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card card-primary card-outline">

                                <div class="card-header">
                                    <h3 class="card-title">
                                        Survey Status
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="panel-body mt-4">
                                        <div id="survey_status_chart" class="mt-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-primary card-outline" style="overflow-x: scroll">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Overall Survey Status
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="row mt-4 mx-2">
                                        <div class="col-md-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Today Survey</span>
                                                    <span class="info-box-number">{{ $status['today']['total'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-success">
                                                <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Weekly Survey </span>
                                                    <span class="info-box-number">{{ $status['weekly']['total'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-gradient-warning">
                                                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Monthly Survey </span>
                                                    <span class="info-box-number">{{ $status['monthly']['total'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-gradient-danger">
                                                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Yearly Survey </span>
                                                    <span class="info-box-number">{{ $status['yearly']['total'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Active Survey List
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Survey Name</th>
                                                <th>Fiscal Year</th>
                                                <th>Survey Year</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($surveyList as $key => $survey)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $survey->survey_name }}</td>
                                                    <td>{{ $survey->fiscalyear->fy_name ?? null }}</td>
                                                    <td>{{ $survey->survey_year }}</td>
                                                    <td>{{ $survey->start_date ?? null }}</td>
                                                    <td>{{ $survey->end_date ?? null }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary card-outline" style="overflow-x: scroll">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Today's Survey Status
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="row mt-4 mx-2">
                                        <div class="col-md-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Total Survey</span>
                                                    <span class="info-box-number">{{ $status['today']['total'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-success">
                                                <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">Completed Survey </span>
                                                    <span
                                                        class="info-box-number">{{ $status['today']['complete'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-gradient-warning">
                                                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">In Progress Survey </span>
                                                    <span
                                                        class="info-box-number">{{ $status['today']['inprogress'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="info-box bg-gradient-danger">
                                                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text font-weight-bold">In Completed Survey
                                                    </span>
                                                    <span
                                                        class="info-box-number">{{ $status['today']['incomplete'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Survey Complete Organization
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Organization Name</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (count($completeList) > 0)
                                                @foreach ($completeList as $key => $val)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $val->organization->org_name }}</td>
                                                        <td>{{ $val->start_date }}</td>
                                                        <td>{{ $val->finish_date }}</td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center"> Data Not Available</td>

                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                @if (count($completeList) >= 11)
                                    <div class="card-footer clearfix">
                                        <a href="{{ url('/complete_survey') }}"
                                            class="btn btn-sm btn-secondary float-right">View
                                            All </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
        </section>
    </div>
@endsection
@push('custom-scripts')
    <script src="{{ url('lib/HighCharts/code/highcharts.js') }}"></script>

    <script>
        var data = {!! json_encode($surveyStatus) !!};
        var category = ['Total', 'Inprogress', 'Complete'];

        $('#survey_status_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Survey Status'
            },
            xAxis: {
                categories: category,
                crosshair: true
            },
            yAxis: {
                title: {
                    text: 'Status'
                }
            },
            series: [{
                name: 'Status',
                data: [data.total, data.inprogress, data.complete],

            }]
        });
    </script>
@endpush
