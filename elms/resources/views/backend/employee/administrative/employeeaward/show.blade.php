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
                            {{--                                                        <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Award</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Award</strong></h3>
                                <a href="{{url('/orgs/employee/award/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/award')}}" class="pull-right cardTopButton" data-toggle="tooltip"
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
                                <th>Employee Name</th>
                                <th>Fiscal Year</th>
                                <th style="width: 10px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($award_details as $key=>$award)
                                @foreach($award as $award_detail )
                                <tr>
                                    <th scope=row>{{$i}}</th>
                                    <td>{{$award_detail->employee->employee_name??null}}</td>
                                    <td>{{$award_detail->fiscal->fy_name??null}}</td>

                                    </td>
                                    <td class="text-right row" style="margin-right: 0px;">
                                        {!! Form::open(['method'=>'get','url'=>'/orgs/employee/award/view/'.$award_detail->employee_id,'enctype'=>'multipart/form-data','file'=>true]) !!}
                                        <input type="hidden" value="{{$award_detail->fiscal->id}}" name="fiscal"/>
                                        <button
                                           class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                        {!! Form::close() !!}
                                        {!! Form::open(['method'=>'get','route'=>['award.edit',$award_detail->employee_id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                        <input type="hidden" value="{{$award_detail->fiscal->id}}" name="fiscal"/>
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
