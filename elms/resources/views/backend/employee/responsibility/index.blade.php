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
                        <h1>Responsibility</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> Responsibility</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Responsibility</strong></h3>
                                <a href="{{url('/orgs/employee/responsibility/create')}}"
                                   class="pull-right cardTopButton" id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                                                            style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/responsibility')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!count($responsibilities)<=0)
                            <table id="example1"
                                   class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">{{trans('app.sn')}}</th>
                                    <th>Employee Name</th>
                                    <th>Responsibility</th>
                                    <th>Level</th>
                                    <th>Field</th>
                                    <th>Present Working Section/s</th>
                                    <th>Name of Immediate Supervisor</th>
                                    <th> Name of Ultimate Supervisor</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php $i = 1;?>
                                @foreach($responsibilities as $key=>$responsibility)
                                    <tr>

                                        <th scope=row>{{$i}}</th>
                                        <td>{{$responsibility->employee->employee_name??null}}</td>
                                        <td>{{$responsibility->employeeResponsibilities->name??null}}</td>
                                        <td>{{$responsibility->level??null}}</td>
                                        <td>{{$responsibility->field??null}}</td>
                                        <td>{{$responsibility->present_working_sector??null}}</td>
                                        <td>{{$responsibility->name_of_supervisor??null}}</td>
                                        <td>{{$responsibility->name_of_ultimate_supervisor??null}}</td>
                                        <td class="text-center">
{{--                                            {!! Form::open(['method' => 'GET', 'route'=>['responsibility.show',--}}
{{--                                                $responsibility->id],'class'=> 'inline']) !!}--}}
{{--                                            <button type="submit" class="text-info btn btn-xs btn-default">--}}
{{--                                                <i class="fa fa-eye"></i>--}}
{{--                                            </button>--}}

                                            {!! Form::close() !!}
                                            <a href="{{url('/orgs/employee/responsibility/'.$responsibility->id .'/edit')}}"
                                               class="text-info btn btn-xs btn-default">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>


                                            {!! Form::open(['method' => 'DELETE', 'route'=>['responsibility.destroy',
                                                 $responsibility->id],'class'=> 'inline']) !!}
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
