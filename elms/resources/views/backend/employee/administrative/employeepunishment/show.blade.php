
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
                            {{--                                                        <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Punishment</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Punishment</strong></h3>
                                <a href="{{url('/orgs/employee/punishment/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/punishment')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                <th> Name</th>
                                <th>Year</th>
                                <th style="width: 10px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($employee_punishments as $key=>$employee_p)
                                @foreach($employee_p as $employee_punishment )

                                <tr>
                                    <th scope=row>{{$i}}</th>
                                    <td>{{$employee_punishment->employee->employee_name}}</td>
                                    <td>{{$employee_punishment->fiscal->fy_name}}</td>

                                    </td>
                                    <td class="text-right row" style="margin-right: 0px;">
                                        {!! Form::open(['method'=>'get','url'=>'/orgs/employee/punishment/view/'.$employee_punishment->employee_id,'enctype'=>'multipart/form-data','file'=>true]) !!}
                                        <input type="hidden" value="{{$employee_punishment->fiscal->id}}" name="fiscal"/>
                                        <button
                                            class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        {!! Form::close() !!}
                                        {!! Form::open(['method'=>'get','route'=>['punishment.edit',$employee_punishment->employee_id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                        <input type="hidden" value="{{$employee_punishment->fiscal->id}}" name="fiscal"/>
                                        <button type="submit"
                                                class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                {{--                                    {{$economicsectors->appends(request()->input())->links()}}--}}

                <!-- /.card-body -->
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
