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
                            <li class="breadcrumb-item active">Leave</li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Award</strong></h3>
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
                            @if(!count($employees)<=0)
                                {!! Form::open(['method'=>'post','url'=>'/orgs/employee/leave','enctype'=>'multipart/form-data','file'=>true]) !!}

                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                    <label>Select Year: </label>
                                                    {{Form::select('year',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'year','placeholder'=>
                                                    'Select Year' , 'required' => 'required'])}}
                                                    {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <table class="table table-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                            <th>Employee</th>
                                                            <th>Leave Type</th>
                                                            <th>Paid Leave</th>
                                                            <th>Paid Leave (Days Spent)</th>


                                                        </tr>
                                                        </thead>
                                                        <?php $i = 1; ?>
                                                        <tbody>
                                                        @foreach($employees as $key=>$employee)
                                                            <tr>
                                                                <th scope=row>{{$i}}</th>
                                                                <input type="hidden" name="ids[]"
                                                                       value="{{ $employee->id }}">
                                                                <td>{{$employee->employee_name}}</td>
                                                                <div class="row">

                                                                    <td>
                                                                        <div class="row">
                                                                                <div class="col-md-12">
                                                                                    {{Form::select('leavetype_id[]',$leave_types->pluck('leave_type','id'),Request::get('id'),['class'=>'form-control
                                                                                        select2','id'=>'leavetype_id','placeholder'=>
                                                                                            'Select Leave Type','required'=>'required','style'=>'width:100%'])}}
                                                                                </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-md-11">

                                                                                <div
                                                                                    class="form-group {{ ($errors->has('paid_leave'))?'has-error':'' }}">
                                                                                    <div class="input-group mb-6">
                                                                                        {!! Form::number('paid_leave[]',null,['class'=>'form-control','placeholder'=>'Paid Leave','id'=>'paid_leave[]','required' => 'required']) !!}
                                                                                    </div>
                                                                                    {!! $errors->first('paid_leave', '<span class="text-danger">:message</span>') !!}
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-md-11">

                                                                                <div
                                                                                    class="form-group {{ ($errors->has('paid_leave_used'))?'has-error':'' }}">
                                                                                    <div class="input-group mb-10">
                                                                                        {!! Form::number('paid_leave_used[]',null,['class'=>'form-control','placeholder'=>'Paid Leave (Days Spent)','id'=>'paid_leave_used[]','required' => 'required']) !!}
                                                                                    </div>
                                                                                    {!! $errors->first('paid_leave_used', '<span class="text-danger">:message</span>') !!}
                                                                                </div>
                                                                            </div>


                                                                        </div>

                                                                    </td>


                                                                </div>

                                                            </tr>

                                                            <?php $i++; ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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


                    {{ Form::close() }}
                </div>
                @else
                    <div class="col-md-12">
                        <label class="form-control label-danger">Please Add Employ Record First </label>
                    </div>
                @endif
            </div>
    </div>
    </div>
    </section>
    </div>

@endsection

@section('js')


@endsection
