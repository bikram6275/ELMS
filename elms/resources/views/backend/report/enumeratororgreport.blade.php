@extends('backend.layouts.app')
@section('title')
    Enumerator Report
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Enumerator Wise Organization Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Enumerator Wise Organization Report</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Enumerator Wise Organization Report</strong>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            <div class="row">
                                {!! Form::open(['method' => 'get', route('enumerator.org'), 'enctype' => 'multipart/form-data']) !!}
                                <div class="col-md-4 form-group">
                                    {!! Form::select('enumerator_id', $enumerators->pluck('name', 'id'), Request::get('enumerator_id'), ['class' => 'form-control select2', 'id' => 'enumerator_id', 'placeholder' => 'Select Enumerator']) !!}
                                </div>
                                <div class="col-md-4 form-group">
                                    {!! Form::select('survey_id', $surveys->pluck('survey_name', 'id'), Request::get('survey_id'), ['class' => 'form-control select2', 'id' => 'survey_id', 'placeholder' => 'Select Survey']) !!}
                                </div>
                                <div class="col-md-2 ">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                                {!! Form::close() !!}
                                <div class=" col-md-2">
                                    {!! Form::open(['method' => 'get', 'url' => '/export/enumerator', 'enctype' => 'multipart/form-data']) !!}
                                    <input type="hidden" name="enumerator_id" , value="{{ request()->enumerator_id }}">
                                    <input type="hidden" name="survey_id" , value="{{ request()->survey_id }}">
                                    <button type="submit" class="btn btn-default pull-right"><i
                                            class="fas fa-file-excel"></i> Export</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
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
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <th scope=row>{{ $i }}</th>
                                        <td>{{ $row->organization?$row->organization->org_name:'-' }}</td>
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
