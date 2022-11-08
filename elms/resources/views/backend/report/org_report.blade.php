@extends('backend.layouts.app')
@section('title')
    Enumerator Report
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
                        <h1>Organization Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Organization Report</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Organization Report</strong>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['method' => 'get', route('orgReport.index'), 'enctype' => 'multipart/form-data']) !!}
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::select('survey_id', $survey_helper->dropdown(), Request::get('survey_id'), ['class' => 'form-control select2', 'id' => 'survey_id', 'placeholder' => 'Select Survey']) !!}
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('pradesh_id'), ['class' => 'form-control select2', 'id' => 'pradesh_id', 'placeholder' => 'Select Pradesh']) !!}
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('district_id'), ['class' => 'form-control select2', 'id' => 'district_id', 'placeholder' => 'Select District']) !!}
                            </div>
                            <div class="col-md-4 form-group">
                                {!! Form::select('sector_id', $sectors->pluck('sector_name', 'id'), Request::get('sector_id'), ['class' => 'form-control select2', 'id' => 'sector_id', 'placeholder' => 'Select Sector']) !!}
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6" style="background-color: aliceblue">
                                <h5 class="text-center my-4"> Approved Organizations</h5>
                                <table id="example" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                            <th>Organization Name</th>
                                            <th>Survey Status</th>
                                            <th>Survey Start Date</th>
                                            <th>Survey Complete Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($approved_organizations as $key => $row)
                                            <tr>
                                                <th scope=row>{{ $i }}</th>
                                                <td>{{ $row->organization ? $row->organization->org_name : '-' }}</td>
                                                <td>{{ $row->finish_date != null? 'Completed': ($row->start_date != null && ($row->finish_date = null)? 'Started': 'Not Started') }}
                                                </td>
                                                <td>{{ $row->start_date }}</td>
                                                <td>{{ $row->finish_date }}</td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="background-color: aliceblue">
                                <h5 class="text-center my-4">Not Approved Organizations</h5>
                                <table id="example" class="table table-striped table-bordered table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                            <th>Organization Name</th>
                                            <th>Survey Status</th>
                                            <th>Survey Start Date</th>
                                            <th>Survey Complete Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($assigned_organizations as $key => $row)
                                            <tr>
                                                <th scope=row>{{ $i }}</th>
                                                <td>{{ $row->organization ? $row->organization->org_name : '-' }}</td>
                                                <td>{{ $row->finish_date != null? 'Completed': ($row->start_date != null && ($row->finish_date = null)? 'Started': 'Not Started') }}
                                                </td>
                                                <td>{{ $row->start_date }}</td>
                                                <td>{{ $row->finish_date }}</td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
    </div>
    </section>
    <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection
