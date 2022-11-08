@extends('backend.layouts.app')
@section('title')
    Employee Award
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Award</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Employee Award</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            {!! Form::model($edits, ['method'=>'get','url'=>'/orgs/employee/update','enctype'=>'multipart/form-data','file'=>true]) !!}
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">

                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Employee Award</h3>
                            <a href="{{url('/orgs/employee/award/create')}}" class="pull-right cardTopButton" id="add"
                               data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/award')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div
                                                            class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                            <label>Employee: </label>
                                                            {{Form::select('employee_id',$employees->pluck('employee_name','id'),$edits[0]->employee_id,['class'=>'form-control
                                                            select2','id'=>'employee_id','name'=>'employee_id','placeholder'=>
                                                            'Select Employee'])}}
                                                            {!! $errors->first('employee_id', '<span
                                                                class="text-danger">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div
                                                            class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                            <label>Select Year: </label>
                                                            {{Form::select('fy_id',$fiscalyears->pluck('fy_name','id'),$edits[0]->fy_id,['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                                            'Select Year' , 'required' => 'required'])}}
                                                            {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="table table-responsive" id="dynamicTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Number of Grade Earned</th>
                                                        <th>Number of Promotion Received</th>
                                                        <th>Appreciation Letter</th>
                                                        <th>Employee of Year</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody class="add_item">
                                                    <tr>
                                                        <input type="hidden" value="{{$edits[0]->id}}" name="id"/>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('grade_earned'))?'has-error':'' }}">
                                                                        <div class="input-group mb-12">
                                                                            {!!
                                                                            Form::number('grade_earned',$edits[0]->grade_earned,['class'=>'form-control','placeholder'=>'Grade Earned','id'=>'grade_earned','required'
                                                                            => 'required']) !!}
                                                                        </div>
                                                                        {!! $errors->first('grade_earned', '<span
                                                                            class="text-danger">:message</span>')
                                                                        !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('promotion_received'))?'has-error':'' }}">
                                                                        <div class="input-group mb-12">
                                                                            {!!
                                                                            Form::number('promotion_received',$edits[0]->promotion_received,['class'=>'form-control','placeholder'=>'Promotion Received','id'=>'promotion_received','required'
                                                                            => 'required']) !!}
                                                                        </div>
                                                                        {!! $errors->first('promotion_received', '<span
                                                                            class="text-danger">:message</span>')
                                                                        !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group{{ $errors->has('appreciation_letter') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="appreciation_letter"
                                                                                id="appreciation_letter">
                                                                            <option value="0" {{  $edits[0]->appreciation_letter==0?'selected':''}}>No</option>
                                                                            <option value="1" {{  $edits[0]->appreciation_letter==1?'selected':''}}>Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('appreciation_letter', '<span class="text-danger">:message</span>') !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group{{ $errors->has('employee_of_yr') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="employee_of_yr"
                                                                                id="employee_of_yr">
                                                                            <option value="0" {{  $edits[0]->employee_of_yr==0?'selected':''}}>No</option>
                                                                            <option value="1" {{  $edits[0]->employee_of_yr==1?'selected':''}}>Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('employee_of_yr', '<span class="text-danger">:message</span>') !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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



