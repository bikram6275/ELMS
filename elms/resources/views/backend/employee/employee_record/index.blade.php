@extends('backend.layouts.app')
@section('title')
    Employee
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            {{-- <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Employee</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee</strong></h3>
                                <a href="{{url('/orgs/employeeRecord/create')}}" class="pull-right cardTopButton"
                                   id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                                                            style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employeeRecord')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        {!!
       Form::open(['method'=>'get','route'=>'employeeRecord.index','enctype'=>'multipart/form-data','file'=>true])
       !!}
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                    <div class="input-group mb-3">
                                        {{Form::select('employee_id',$emp->pluck('employee_name','id'),Request::get('employee_id'),['class'=>'form-control
                                        select2','placeholder'=>
                                        'Select Employee ','name'=>'employee_id'])}}
                                    </div>
                                    {!! $errors->first('employee_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('employee_type_id'))?'has-error':'' }}">
                                    <div class="input-group mb-3">
                                        {{Form::select('employee_type_id',$employeeTypes->pluck('name','id'),Request::get('employee_type_id'),['class'=>'form-control
                                        select2','placeholder'=>
                                        'Select Employee Type','name'=>'employee_type_id'])}}
                                    </div>
                                    {!! $errors->first('employee_type_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    {{Form::select('gender',$genders->pluck('name','id'),Request::get('gender'),['class'=>'form-control
                                    select2','id'=>'gender','name'=>'gender','placeholder'=>
                                    'Select Gender'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info " id="assign_button"><i class="fa fa-search"></i>Search
                                </button>
                                <a href="{{ url('/orgs/employeeRecord') }}" class="btn btn-warning"><i
                                        class="fa fa-refresh"></i> Refresh
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="card-body">
                        @if(!count($employees)<=0)
                            <table id="example1"
                                   class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">{{trans('app.sn')}}</th>
                                    <th>Employee Name</th>

                                    <th>Employee Type</th>
                                    <th>Position</th>

                                    <th>Join Date</th>

                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($employees as $key=>$employee)
                                    <tr>
                                        <th scope=row>{{$i}}</th>
                                        <td>{{$employee->employee_name??null}}</td>
                                        <td>{{$employee->employeeType->name??null}}</td>
                                        <td>{{$employee->first_entry_position??null}}</td>
                                        <td>{{$employee->join_date??null}}</td>
                                        <td class="text-center">
                                            <a href="{{url('/orgs/employeeRecord/'.$employee->id .'/edit')}}"
                                               class="text-info btn btn-xs btn-default">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>

                                            {!! Form::open(['method' => 'GET', 'route'=>['employeeRecord.show',
                                            $employee->id],'class'=> 'inline']) !!}
                                            <button type="submit" class="text-info btn btn-xs btn-default">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            {!! Form::close() !!}

                                            {!! Form::open(['method' => 'DELETE', 'route'=>['employeeRecord.destroy',
                                            $employee->id],'class'=> 'inline']) !!}
                                            <button type="submit" class="btn btn-danger btn-xs deleteButton actionIcon"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete?');">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                            </table>

                    </div>
                    @else
                        <div class="col-md-12">
                            <label class="form-control label-danger">No Employee record found</label>
                        </div>
                    @endif

                </div>
                <!-- /.card -->
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection
