@extends('backend.layouts.app')
@section('title')
    Assigned Organization
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assigned Organization</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('app.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">Assigned Organization</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Assigned Organization</h3>
                                {{-- @if (count($rows) > 0)
                                <a  href="{{ url('report/organizationReport/'.$rows[0]->survey_id) }}" class="btn btn-default pull-right">Export  <i class="fas fa-file-excel"></i></a>
                                @endif --}}
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 topFilter">
                                    {!! Form::open(['method'=>'get','url'=>'field_response/'.request()->id]) !!}
                                    <div class="row">
                                       

                                        <div class="col-md-4">
                                            <div class="form-group {{ ($errors->has('supervisor_id'))?'has-error':'' }}">
                                                {{Form::select('supervisor_id',$supervisors->pluck('name','id'),Request::get('supervisor_id'),['class'=>'form-control select2','id'=>'supervisor_id','name'=>'supervisor_id','placeholder'=>
                                                'Select Supervisor'])}}
                                                {!! $errors->first('supervisor_id', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info " ><i
                                                    class="fa fa-search"></i>Search</button>
        
                                        </div>
                                        {{ Form::close() }}

                                    </div>
                                    <table id="example1"
                                        class="table table-striped table-bordered table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                                <th> Assigned Organization</th>
                                                <th>Enumerator Name</th>
                                                <th>Start Date</th>
                                                <th>Finish Date</th>
                                                <th>Status</th>

                                                <th style="width: 100px !important" ; class="text-right">Action</th>
                                            </tr>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1; ?>
                                            @foreach ($rows as $key => $data)
                                                <tr>
                                                    <td scope=row>{{ $i }}</td>
                                                    <td>{{ $data->organization->org_name }}</td>
                                                    <td>{{ $data->emitter->name }}</td>
                                                    <td>{{ $data->start_date ? $data->start_date : '-' }}</td>
                                                    <td>{{ $data->finish_date ? $data->finish_date : '-' }}</td>

                                                    <td><span
                                                            class="badge {{ $data->finish_date != null? 'badge-success': ($data->start_date != null? 'badge-primary': 'badge-danger') }}">{{ $data->finish_date != null ? 'Complete' : ($data->start_date != null ? 'Started' : 'Not Started') }}</span>
                                                            <span class="badge {{ $data->status == 'supervised' ? 'badge-success' : 'badge-danger' }}">{{ $data->status }}</span>
                                                    </td>
                                                    <td>
                                                        {{-- @if ($data->respondent_name != null)
                                                        <a href="{{ url('survey/orgs/'.$data->id) }}" class="btn btn-xs btn-primary"><strong> Edit Survey </strong> </a>
                                                        @else

                                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#respondent_{{$data->pivot_id}}"><strong> Edit Survey</strong></button>
                                                         @include('admin.formLayout.respondentModel')

                                                        @endif --}}
                                                        <a href="{{ route('field.view', $data->id) }}"
                                                            class=" btn btn-xs btn-secondary">
                                                            <strong> View</strong> </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection
