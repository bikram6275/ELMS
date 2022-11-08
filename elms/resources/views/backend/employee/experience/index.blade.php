@extends('backend.layouts.app')
@section('title')
    Employee Experience
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Employee Experience</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            {{--                                                        <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Experience</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i>  Employee Experience</strong></h3>
                                <a href="{{url('/orgs/employee/experience/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/experience')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                                {!! Form::open(['method'=>'get','url'=>'/orgs/employee/experience/create','enctype'=>'multipart/form-data','file'=>true]) !!}
                                <input  class="pull-right cardTopButton" value="SingleInput" aria-label="Default" name="singleInput" type="submit" id="add" data-toggle="tooltip" style="background:#0398fc;color: white;border-radius: 5px;border: none"
                                        title="Add Single"></i></input>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!count($experience_details)<=0)

                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            {{--                            <div class="row">--}}
                            {{--                                {!! Form::open(['method'=>'get',route('employee.award.index'),'enctype'=>'multipart/form-data']) !!}--}}

                            {{--                                <div class="col-md-4 form-group">--}}
                            {{--                                    {{Form::select('parent_id',$economicsectors->pluck('sector_name','id'),Request::get('parent_id'),['class'=>'form-control select2','id'=>'designation_id','placeholder'=>--}}
                            {{--                                       'Select Sector'])}}--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-2 ">--}}
                            {{--                                    <button type="submit" class="btn btn-primary">Filter</button>--}}
                            {{--                                </div>--}}
                            {{--                                {!! Form::close() !!}--}}
                            {{--                            </div>--}}
                            <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                <th>Employee Name</th>

                                <th style="width: 10px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($experience_details as $key=>$experience_detail)
                                <tr>
                                    <th scope=row>{{$i}}</th>
                                    <td>{{$experience_detail->employee->employee_name??null}}</td>

                                    <td class="align-middle" style="margin-right: 0px;">

                                        <a href="{{url('/orgs/employee/experience/'.$experience_detail->id)}}"
                                           class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <a href="{{url('/orgs/employee/experience/'.$experience_detail->id .'/edit')}}"
                                           class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        {!! Form::open(['method' => 'DELETE', 'route'=>['experience.destroy',
                                                $experience_detail->id],'class'=> 'inline']) !!}
                                        <button type="submit"
                                                class="btn btn-danger btn-xs deleteButton actionIcon"
                                                data-toggle="tooltip"
                                                data-placement="top" title="Delete"
                                                onclick="javascript:return confirm('Are you sure you want to delete?');">
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
