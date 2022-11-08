@extends('backend.layouts.app')
@section('title')
    Employee Punishment
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Punishment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Punishment</li>
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
                            <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Punishment</strong></h3>
                            <a href="{{url('/orgs/employee/punishment/create')}}" class="pull-right cardTopButton"
                               id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/punishment')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>

                        <div class="card-body">
                            @if(!count($employees)<=0)

                                {!! Form::open(['method'=>'post','url'=>'/orgs/employee/punishment','enctype'=>'multipart/form-data','file'=>true]) !!}

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                            <label>Select Year: </label>
                                            {{Form::select('year',$fiscalyears->pluck('fy_name','fy_name'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                            'Select Year' , 'required' => 'required'])}}
                                            {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table table-responsive">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                <th>Employee</th>
                                                <th>Number of Defense Letter Received</th>
                                                <th>Grade deduction Records</th>
                                                <th>De promoted Records</th>
                                                <th>File</th>
                                            </tr>
                                            </thead>
                                            <?php $i = 1; ?>
                                            <tbody>
                                            @foreach($employees as $key=>$employee)
                                                <tr>
                                                    <input type="hidden" name="ids[]"
                                                           value="{{ $employee->id }}">
                                                    <input type="hidden" name="employee_name[]"
                                                           value="{{ $employee->employee_name }}">
                                                    <th scope=row>{{$i}}</th>
                                                    <td>{{$employee->employee_name}}</td>
                                                    <td>
                                                        <div class="col-md-12">
                                                            <div
                                                                class="form-group {{ ($errors->has('defence_letter_received'))?'has-error':'' }}">
                                                                <div class="input-group mb-10">
                                                                    {!! Form::number('defence_letter_received[]',null,['class'=>'form-control','placeholder'=>'No. of Defense Letter Received','required' => 'required']) !!}
                                                                </div>
                                                                {!! $errors->first('defence_letter_received', '<span class="text-danger">:message</span>') !!}
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="col-md-12">
                                                            <div
                                                                class="form-group{{ $errors->has('de_promoted') ? ' has-error' : '' }}">
                                                                <select class="form-control"
                                                                        name="de_promoted[]"
                                                                        id="de_promoted">
                                                                    <option value="0">No</option>
                                                                    <option value="1">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-12">
                                                            <div
                                                                class="form-group{{ $errors->has('grade_deducted') ? ' has-error' : '' }}">
                                                                <select class="form-control"
                                                                        name="grade_deducted[]"
                                                                        id="employee_of_yr">
                                                                    <option value="0">No</option>
                                                                    <option value="1">Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-3">
                                                            <div
                                                                class="form-group{{ $errors->has('punishment_img') ? ' has-error' : '' }}">
                                                                {{Form::file('punishment_img[]',null,['class'=>'form-control','id'=>'org_image','placeholder'=>  'Choose File'])}}
                                                                {!! $errors->first('punishment_img', '<span class="text-danger">:message</span>') !!}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="margin-left: 10px">
                                {{trans('app.save')}}
                            </button>
                        </div>


                        {{ Form::close() }}

                        @else
                            <div class="col-md-12">
                                <label class="form-control label-danger">Please Add Employ Record
                                    First</label>
                            </div>
                        @endif

                    </div>
                </div>
        </section>

    </div>

@endsection

@section('js')

@endsection
