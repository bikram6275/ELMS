@extends('backend.layouts.app')
@section('title')
    Survey
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Survey</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            {{-- <li class="breadcrumb-item">{{trans('app.configuration')}}</li> --}}
                            <li class="breadcrumb-item active">Survey</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                @include('backend.message.flash')
                <div class="card card-default">
                    <div class="card-header with-border">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Survey</strong></h3>
                                <a href="{{ url('/survey/create') }}" class="pull-right cardTopButton" id="add"
                                    data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                        style="font-size:20px;"></i></a>

                                <a href="{{ url('/survey') }}" class="pull-right cardTopButton" data-toggle="tooltip"
                                    title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{ URL::previous() }}" class="pull-right cardTopButton" data-toggle="tooltip"
                                    title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                    <th>Survey Name</th>
                                    <th>Fiscal year</th>
                                    <th>Survey year</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 10px" ; class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($surveys as $key => $survey)
                                    <tr>
                                        <th scope=row>{{ $i }}</th>
                                        <td>{{ $survey->survey_name ?? null }}</td>
                                        <td>{{ $survey->fiscalyear->fy_name ?? null }}</td>
                                        <td>{{ $survey->survey_year ?? null }}</td>
                                        <td>{{ $survey->start_date ?? null }}</td>
                                        <td>{{ $survey->end_date ?? null }}</td>

                                        <td>
                                            @if ($survey->survey_status == 'active')
                                                <a class="label label-success stat"
                                                    href="{{ url('/survey/status', $survey->id) }}">
                                                    <strong class="stat"> Active
                                                    </strong>
                                                </a>
                                            @elseif($survey->survey_status == 'inactive')
                                                <a class="label label-danger stat"
                                                    href="{{ url('/survey/status', $survey->id) }}">
                                                    <strong class="stat"> Inactive
                                                    </strong>
                                                </a>
                                            @endif
                                        </td>

                                        <td class="text-right row" style="margin-right: 0px;">

                                            <a href="{{ route('survey.edit', [$survey->id]) }}"
                                                class="text-info btn btn-xs btn-default" data-toggle="tooltip"
                                                data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
    </div>
    </div>
    </section>
    <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection
