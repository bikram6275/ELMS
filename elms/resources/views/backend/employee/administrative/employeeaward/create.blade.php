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
                            <li class="breadcrumb-item active">Award</li>
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
                            @if(!count($employees)<=0)

                                {!! Form::open(['method'=>'post','url'=>'/orgs/employee/award','enctype'=>'multipart/form-data','file'=>true]) !!}

                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                    <label>Select Year: </label>
                                                    {{Form::select('fy_id',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
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
                                                            <th>Number of Grade Earned</th>
                                                            <th>Number of Promotion Received</th>
                                                            <th>Appreciation Letter</th>
                                                            <th>Employee of Year</th>
                                                        </tr>
                                                        </thead>
                                                        <?php $i = 1; ?>
                                                        <tbody>
                                                        @foreach($employees as $key=>$employee)
                                                            <tr>
                                                                <input type="hidden" name="ids[]"
                                                                       value="{{ $employee->id }}">
                                                                <th scope=row>{{$i}}</th>
                                                                <td>{{$employee->employee_name}}</td>
                                                                <td>
                                                                    <div class="col-md-10">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('grade_earned'))?'has-error':'' }}">
                                                                            <div class="input-group mb-10">
                                                                                {!! Form::number('grade_earned[]',null,['class'=>'form-control','placeholder'=>'Grade Earned','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('grade_earned', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-12">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('promotion_received'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('promotion_received[]',null,['class'=>'form-control','placeholder'=>'Promotion Received', 'required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('promotion_received', '<span class="text-danger">:message</span>') !!}

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-10">

                                                                        <div
                                                                            class="form-group{{ $errors->has('appreciation_letter') ? ' has-error' : '' }}">
                                                                            <select class="form-control"
                                                                                    name="appreciation_letter[]"
                                                                                    id="appreciation_letter">
                                                                                <option value="0">No</option>
                                                                                <option value="1">Yes</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-10">
                                                                        <div
                                                                            class="form-group{{ $errors->has('employee_of_yr') ? ' has-error' : '' }}">
                                                                            <select class="form-control"
                                                                                    name="employee_of_yr[]"
                                                                                    id="employee_of_yr">
                                                                                <option value="0">No</option>
                                                                                <option value="1">Yes</option>
                                                                            </select>
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
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                {{trans('app.save')}}
                                            </button>
                                        </div>


                                        {{ Form::close() }}
                                    </div>
                                    @else
                                        <div class="col-md-12">
                                            <label class="form-control label-danger">Please Add Employ Record
                                                First </label>
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
