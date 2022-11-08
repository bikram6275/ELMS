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
                            {{--                                                        <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Leave</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Leave</strong></h3>
                                <a href="{{url('/orgs/employee/leave/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/leave')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                                {!! Form::open(['method'=>'get','url'=>'/orgs/employee/leave/create','enctype'=>'multipart/form-data','file'=>true]) !!}
                                <input  class="pull-right cardTopButton" value="SingleInput" aria-label="Default" name="singleInput" type="submit" id="add" data-toggle="tooltip" style="background:#0398fc;color: white;border-radius: 5px;border: none"
                                        title="Add Single"></i></input>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!count($employee_leaves)<=0)
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">

                            <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                <th > Year</th>
                                <th style="width: 15px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 1;?>
                            @foreach($employee_leaves as $key=>$employee_leave)
                                <tr>
                                    <th scope=row>{{$i}}</th>
                                    <td>{{$employee_leave->fiscal->fy_name}}</td>
                                    </td>
                                    <td class="align-middle" style="text-align: center">
                                        <a href="{{url('/orgs/employee/leave/'.$employee_leave->year)}}"
                                           class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i> View
                                        </a>

                                    </td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    @else
                        <div class="col-md-12">
                            <label class="form-control label-danger">No records found</label>
                        </div>
                @endif
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
