@extends('backend.layouts.app')
@section('title')
    Employee Leave
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Leave</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Employee Leave</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            {!!
            Form::open(['method'=>'post','url'=>'/orgs/employee/leave','enctype'=>'multipart/form-data','file'=>true])
            !!}
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">

                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Employee Leave</h3>
                            <a href="{{url('/orgs/employee/leave/create')}}" class="pull-right cardTopButton" id="add"
                               data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/leave')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                        <label>Select Year: </label>
                                        {{Form::select('year',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                        'Select Year' , 'required' => 'required'])}}
                                        {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                        <label>Employee Name: </label>
                                        <div class="input-group mb-3">
                                            {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control
                                         select2','id'=>'employee_id','name'=>'ids[]','placeholder'=>
                                         'Employee Name'])}}
                                        </div>
                                        {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('leavetype_id'))?'has-error':'' }}">
                                        <label>Leave Type: </label>
                                        {{Form::select('leavetype_id[]',$leave_types->pluck('leave_type','id'),Request::get('id'),['class'=>'form-control select2','id'=>'leave_id','placeholder'=>
                                        'Select Leave Type' , 'required' => 'required'])}}
                                        {!! $errors->first('leavetype_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ ($errors->has('paid_leave'))?'has-error':'' }}">
                                        <label>Leave: </label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::number('paid_leave[]',null,['class'=>'form-control',
                                            'placeholder'=>'Leave']) !!}
                                        </div>
                                        {!! $errors->first('paid_leave', '<span class="text-danger">:message</span>')
                                        !!}

                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group {{ ($errors->has('paid_leave_used'))?'has-error':'' }}">
                                        <label> Leave (Days Spent): </label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::number('paid_leave_used[]',null,['class'=>'form-control',
                                            'placeholder'=>'Leave (Days Spent)']) !!}
                                        </div>
                                        {!! $errors->first('paid_leave_used', '<span class="text-danger">:message</span>')
                                        !!}

                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('app.save')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

        </section>
    </div>


@endsection



