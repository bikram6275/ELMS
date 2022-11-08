@extends('backend.layouts.app')
@section('title')
    Employee Responsibility
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Responsibility</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Employee Responsibility</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            {!!
            Form::model($edits,['method'=>'put','route'=>['responsibility.update',$edits->id],'enctype'=>'multipart/form-data','file'=>true])
            !!}
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">

                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Employee Responsibility</h3>
                            <a href="{{url('/orgs/employee/responsibility/create')}}" class="pull-right cardTopButton"
                               id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/responsibility')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                        <label>Employee Name: </label>
                                        <div class="input-group mb-3">
                                            {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control
                                         select2','id'=>'employee_id','name'=>'employee_id','placeholder'=>
                                         'Employee Name'])}}
                                        </div>
                                        {!! $errors->first('employee_name', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group {{ ($errors->has('date_of_birth'))?'has-error':'' }}">
                                        <label>Responsibility: </label>
                                        <div class="input-group mb-3">

                                            {{Form::select('name',$responsibility->pluck('name','id'),$edits->responsibility_type,['class'=>'form-control
                                         select2','id'=>'responsibility_type','name'=>'responsibility_type','placeholder'=>
                                         'Responsibility'])}}
                                        </div>
                                        {!! $errors->first('date_of_birth', '<span class="text-danger">:message</span>') !!}
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('level'))?'has-error':'' }}">
                                        <label>Level: </label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::text('level',null,['class'=>'form-control',
                                            'placeholder'=>'Level']) !!}
                                        </div>
                                        {!! $errors->first('level', '<span class="text-danger">:message</span>')
                                        !!}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('field'))?'has-error':'' }}">
                                        <label>Field: </label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::text('field',null,['class'=>'form-control',
                                            'placeholder'=>'Field']) !!}
                                        </div>
                                        {!! $errors->first('field', '<span class="text-danger">:message</span>')
                                        !!}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('present_working_sector'))?'has-error':'' }}">
                                        <label>Present Working Section/s</label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::text('present_working_sector',null,['class'=>'form-control',
                                            'placeholder'=>'Present Working Section/s']) !!}
                                        </div>
                                        {!! $errors->first('present_working_sector', '<span class="text-danger">:message</span>')
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('name_of_supervisor'))?'has-error':'' }}">
                                        <label>Name of Immediate Supervisor: </label>
                                        <div class="input-group mb-3">
                                            {!!
                                            Form::text('name_of_supervisor',null,['class'=>'form-control',
                                            'placeholder'=>'Name of supervisor']) !!}
                                            {!! $errors->first('name_of_supervisor', '<span
                                                class="text-danger">:message</span>')
                                            !!}
                                        </div>
                                        {!! $errors->first('phone_no', '<span class="text-danger">:message</span>')
                                        !!}

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('name_of_ultimate_supervisor'))?'has-error':'' }}">
                                        <label>Name of Ultimate Supervisor: </label>
                                        <div class="input-group mb-3">
                                            {!!
                                           Form::text('name_of_ultimate_supervisor',null,['class'=>'form-control',
                                           'placeholder'=>'Name of ultimate supervisor']) !!}
                                        </div>
                                        {!! $errors->first('name_of_ultimate_supervisor', '<span
                                            class="text-danger">:message</span>')
                                        !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('app.update')}}
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



